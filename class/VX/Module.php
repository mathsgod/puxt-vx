<?php

namespace VX;

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;
use League\Route\Http\Exception\ForbiddenException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnauthorizedException;
use League\Route\RouteCollectionInterface;
use Psr\Http\Message\ServerRequestInterface;
use R\DB\Model;
use Symfony\Component\Yaml\Yaml;
use VX;
use VX\Model as VXModel;

class Module implements TranslatorAwareInterface, ResourceInterface, MenuItemInterface
{
    use TranslatorAwareTrait;

    public $name;
    public $class;
    public $icon = "far fa-circle";
    public $group;
    public $sequence = PHP_INT_MAX;
    public $hide = false;


    public $menu = [];

    /**
     * @var AclInterface $acl
     */
    public $acl;

    /**
     * @var ModuleFile[] $files
     */
    public $files = [];

    /**
     * @var VX $vx
     */
    public $vx;

    public function __construct(VX $vx, string $name)
    {
        $this->vx = $vx;
        $this->name = $name;
        $this->class = $name;

        // load all system files
        $base[] = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $this->name;
        $base[] = getcwd() . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $this->name;

        foreach ($base as $b) {

            if (file_exists($b)) {
                $adapter = new \League\Flysystem\Local\LocalFilesystemAdapter($b);
                $fs = new \League\Flysystem\Filesystem($adapter);
                $files = $fs->listContents('/', true)->filter(function (StorageAttributes $attributes) {
                    return $attributes->isFile();
                })->filter(function (FileAttributes $attributes) {
                    $ext = pathinfo($attributes->path(), PATHINFO_EXTENSION);
                    return $ext == "php" || $ext == "twig" || $ext == "html";
                })->toArray();

                foreach ($files as $file) {

                    $ext = pathinfo($file["path"], PATHINFO_EXTENSION);
                    $path = substr($file["path"], 0, - (strlen($ext) + 1));

                    $this->files[$path] = new ModuleFile($this, $path, $b . DIRECTORY_SEPARATOR . $path);
                }
            }

            //load config 
            if (file_exists($setting = $b . DIRECTORY_SEPARATOR . "setting.yml")) {
                $config = Yaml::parseFile($setting);
                if (isset($config["class"])) {
                    $this->class = $config["class"];
                }
                if (isset($config["icon"])) {
                    $this->icon = $config["icon"];
                }
                if (isset($config["group"])) {
                    $this->group = $config["group"];
                }
                if (isset($config["sequence"])) {
                    $this->sequence = $config["sequence"];
                }
                if (isset($config["hide"])) {
                    $this->hide = $config["hide"];
                }
                if (isset($config["show_create"])) {
                    $this->show_create = $config["show_create"];
                }

                if (isset($config["menu"])) {
                    $this->menu = $config["menu"];
                }
            }
        }



        $this->files = array_values($this->files);
    }


    public function isHide(): bool
    {
        return $this->hide;
    }

    public function getLabel(): string
    {
        return $this->name;
    }

    public function getLink(): ?string
    {
        return null;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getModuleGroup()
    {
        if (isset($this->group)) {
            return ModuleGroup::Get($this->group);
        }
        return null;
    }


    /**
     * @return ModuleMenu[]
     */
    public function getMenus(): array
    {
        $items = [];

        if ($this->show_create) {
            $items[] = new ModuleMenu([
                "label" => "Add",
                "icon" => "add",
                "link" => "/" . $this->name . "/add"
            ], $this->acl);
        }

        $items[] = new ModuleMenu([
            "label" => "List",
            "icon" => "list",
            "link" => "/" . $this->name
        ], $this->acl);

        foreach ($this->menu as $m) {
            $items[] = new ModuleMenu($m, $this->acl);
        }

        return $items;
    }

    private function getQueryData(string $class, array $query, ServerRequestInterface $request)
    {
        $meta = [];
        $meta["primaryKey"] = $class::_key();

        /** @var \R\DB\Query */
        $q = $class::Query();

        if ($filters = $query["filters"]) {

            foreach ($filters as $field => $filter) {

                foreach ($filter as $operator => $value) {
                    if ($operator == '$eq') {
                        $q->where->equalTo($field, $value);
                    }

                    if ($operator == '$contains') {
                        $q->where->like($field, "%$value%");
                    }

                    if ($operator == '$in') {
                        $q->where->in($field, $value);
                    }

                    if ($operator == '$between') {
                        $q->where->between($field, $value[0], $value[1]);
                    }
                }
            }
        }

        if ($sort = $query["sort"]) {
            $order = [];
            foreach ($sort as $s) {
                $ss = explode(":", $s);

                $order[$ss[0]] = $ss[1];
            }
            $q->order($order);
        }

        if ($pagination = $query["pagination"]) {
            $paginator = $q->getPaginator();
            $paginator->setCurrentPageNumber($pagination["page"]);
            $paginator->setItemCountPerPage($pagination["pageSize"]);

            $q = $paginator;

            $meta["pagination"] = [
                "page" => $paginator->getCurrentPageNumber(),
                "pageSize" => $paginator->getItemCountPerPage(),
                "total" => $paginator->getTotalItemCount()
            ];
        }

        $data = [];
        foreach ($q as $o) {
            if ($o instanceof VXModel) {
                if ($o->canReadBy($request->getAttribute("user"))) {
                    $obj = $o->toArray($query["fields"] ?? []);
                    if ($populate = $query["populate"]) {
                        foreach ($populate as $target_module => $p) {
                            $module = $this->vx->getModule($target_module);

                            $target_class = $module->class;

                            $target_key = $target_class::_key();

                            $p["filters"] = $p["filters"] ?? [];

                            if (in_array($target_key, $o->__fields())) { // many to one
                                $p["filters"][$target_key]['$eq'] = $o->$target_key;
                                $d = $this->getQueryData($module->class, $p, $request);
                                $d["data"] = $d["data"][0];
                            } else { //one to many


                                $p["filters"][$meta["primaryKey"]]['$eq'] = $o->{$meta["primaryKey"]};
                                $d = $this->getQueryData($module->class, $p, $request);
                            }



                            $obj[$target_module] = $d["data"];
                        }
                    }

                    $data[] = $obj;
                }
            }
        }

        return  [
            "data" => $data,
            "meta" => $meta
        ];
    }

    private function getModuleFile(string $path)
    {
        foreach ($this->files as $file) {
            if ($file->path == $path) {
                return $file;
            }
        }
    }

    function setupRoute(RouteCollectionInterface $route)
    {

        $route->get($this->name . "/{id:number}", function (ServerRequestInterface $request, array $args) {
            $user = $request->getAttribute("user");
            $object = $this->getObject($args["id"]);
            if (!$object) {
                throw new NotFoundException();
            }
            if (!$object->canReadBy($user)) {
                throw new ForbiddenException();
            }

            $meta = [];
            $data = [];

            if ($object instanceof Model) {
                $meta["primaryKey"] = $object->_key();

                $fields = [];
                foreach ($object->__attributes() as $attr) {

                    if ($attr["Type"] == "longblob" || $attr["Type"] == "blob") {
                    } else {
                        $data["data"][$attr["Field"]] = $object->{$attr["Field"]};
                        $fields[] = $attr["Field"];
                    }
                }

                $fields = $request->getQueryParams()["fields"] ?? $fields;
                $data["data"] = $object->toArray($fields);
            } else {
                $data["data"] = $object;
            }




            $data["meta"] = $meta;

            return new JsonResponse($data);
        });


        $route->post($this->name, function (ServerRequestInterface $request, array $args) {
            if (strstr($request->getHeaderLine("Content-Type"), "application/json")) {
                $user = $request->getAttribute("user");

                $object = $this->createObject();
                if (!$object->canCreateBy($user)) {
                    throw new ForbiddenException();
                }

                $data = $request->getParsedBody();
                $object->bind($data);
                $object->save();

                return new EmptyResponse(201, [
                    "Content-Location" => $object->uri()
                ]);
            }
            throw new NotFoundException();
        });

        $route->patch($this->name . "/{id:number}", function (ServerRequestInterface $request, array $args) {
            if (strstr($request->getHeaderLine("Content-Type"), "application/json")) {
                $user = $request->getAttribute("user");
                $object = $this->getObject($args["id"]);

                if (!$object) {
                    throw new NotFoundException();
                }
                if (!$object->canUpdateBy($user)) {
                    throw new ForbiddenException();
                }

                $data = $request->getParsedBody();

                $object->bind($data);
                $object->save($data);
                return new EmptyResponse(204, [
                    "Content-Location" => $object->uri()
                ]);
            }
            throw new NotFoundException();
        });

        $route->delete($this->name . "/{id:number}", function (ServerRequestInterface $request, array $args) {
            $user = $request->getAttribute("user");
            $object = $this->getObject($args["id"]);
            if (!$object) {
                throw new NotFoundException();
            }
            if (!$object->canDeleteBy($user)) {
                throw new ForbiddenException();
            }

            $object->delete();
            return new EmptyResponse();
        });

        $route->get($this->name, function (ServerRequestInterface $request, array $args) {

            if (!$this->vx->logined) {
                throw new  UnauthorizedException();
            }

            $query = $request->getQueryParams();
            $data = $this->getQueryData($this->class, $query, $request);
            $data["meta"]["model"] = $this->name;
            return new JsonResponse($data);
        });

        $methods = ["GET", "POST", "PATCH", "DELETE"];
        foreach ($methods as $method) {
            foreach ($this->files as $file) {
                $that = $this;

                $path = $this->name . "/" . $file->path;
                $path = str_replace("@", ":", $path);
                $route->map($method, $path, function (ServerRequestInterface $request, array $args) use ($file, $that) {
                    $this->vx->module = $that;

                    $twig = $this->vx->getTwig(new \Twig\Loader\FilesystemLoader(dirname($file->file)));
                    $request = $request->withAttribute("twig", $twig);

                    return $file->handle($request);
                });


                $path = $this->name . "/{id:number}/" . $file->path;
                $path = str_replace("@", ":", $path);

                $route->map($method, $path, function (ServerRequestInterface $request, array $args) use ($file, $that, $path) {

                    $this->vx->object_id = $args["id"];
                    $this->vx->module = $that;

                    $twig = $this->vx->getTwig(new \Twig\Loader\FilesystemLoader(dirname($file->file)));
                    $request = $request->withAttribute("twig", $twig);

                    return $file->handle($request);
                });
            }
        }
    }


    function getRouterMap()
    {
        $map = [];


        $methods = ["GET", "POST", "PATCH", "DELETE"];
        foreach ($methods as $method) {
            foreach ($this->files as $file) {
                $map[] = [
                    "method" => $method,
                    "path" => $this->name . "/" . $file->path,
                    "handler" => $file,
                    "file" => $file->file
                ];

                $map[] = [
                    "method" => $method,
                    "path" => $this->name . "/{id:number}/" . $file->path,
                    "handler" => $file,
                    "file" => $file->file
                ];
            }
        }



        return $map;
    }



    public function getResourceId()
    {
        return $this->name;
    }

    public function setAcl(AclInterface $acl)
    {
        $this->acl = $acl;
    }

    /**
     * @return ModuleFile[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    public function loadConfigFile(string $filename)
    {
        if (file_exists($filename)) {
            $yaml = new Yaml;
            $config = $yaml->parseFile($filename);
            foreach ($config as $k => $v) {
                $this->$k = $v;
            }
        }
    }

    public function createObject(): ?IModel
    {
        $class = $this->class;
        if (!$class) return null;
        return new $class;
    }

    public function getObject(int $id): ?IModel
    {
        $class = $this->class;
        return $class::Get($id);
    }

    public function getMenuItemByUser(User $user): array
    {
        if ($this->hide) {
            return [];
        }

        $menus = [];


        foreach ($this->getMenus() as $menu) {
            if (!$this->acl->isAllowed($user, $menu)) {
                continue;
            }


            $menus[] = $menu->getMenuLinkByUser($user);
        }



        if (count($menus) == 0) {
            return [];
        }

        $data = [];
        $data["label"] = $this->translator->trans($this->name);
        $data["icon"] = $this->icon;

        $data["link"] = "#";
        $data["name"] = $this->name;
        $data["menus"] = $menus;

        if (count($menus) == 1) {

            if ($menus[0]["link"] == ("/" . $this->name)) {
                $data["link"] = "/" . $this->name;
                $data["menus"] = null;
            }
        }

        return $data;
    }


    function __debugInfo()
    {
        return [
            "name" => $this->name,
            "class" => $this->class,
            "icon" => $this->icon,
            "group" => $this->group,
            "sequence" => $this->sequence,
            "hide" => $this->hide,
            "show_create" => $this->show_create,
            "menu" => $this->menu,
            "files" => $this->files
        ];
    }
}
