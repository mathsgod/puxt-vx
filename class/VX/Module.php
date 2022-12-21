<?php

namespace VX;

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Permissions\Rbac\AssertionInterface;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\RoleInterface;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;
use League\Route\Http\Exception\ForbiddenException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnauthorizedException;
use League\Route\RouteCollectionInterface;
use VX\Security\UserInterface;
use Psr\Http\Message\ServerRequestInterface;
use R\DB\Model;
use Symfony\Component\Yaml\Yaml;
use VX;
use VX\Model as VXModel;
use VX\Security\Security;

class Module implements TranslatorAwareInterface, MenuItemInterface, AssertionInterface
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
     * @var ModuleFile[] $files
     */
    public $files = [];

    /**
     * @var VX $vx
     */
    public $vx;


    protected $security;

    public function __construct(VX $vx, string $name, Security $security)
    {
        $this->security = $security;
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

    public function assert(Rbac $rbac, RoleInterface $role, string $permission): bool
    {
        //check module file has true
        foreach ($this->files as $file) {
            if ($file->assert($rbac, $role, $permission)) {
                return true;
            }
        }
        return false;
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
                "name" => $this->name . ".add",
                "label" => "Add",
                "icon" => "add",
                "link" => "/" . $this->name . "/add"
            ]);
        }

        $items[] = new ModuleMenu([
            "name" => $this->name . ".list",
            "label" => "List",
            "icon" => "list",
            "link" => "/" . $this->name
        ]);

        foreach ($this->menu as $m) {
            $items[] = new ModuleMenu($m);
        }

        return $items;
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

        $rbac = $this->rbac;
        $route->get($this->name . "/{id:number}", function (ServerRequestInterface $request, array $args) use ($rbac) {
            /**
             * @var UserInterface $user
             */
            $user = $request->getAttribute(UserInterface::class);
            $object = $this->getObject($args["id"]);
            if (!$object) {
                throw new NotFoundException();
            }

            $granted = false;
            foreach ($user->getRoles() as $role) {
                if ($rbac->isGranted($role->getName(), "read", $object)) {
                    $granted = true;
                    break;
                }
            }

            if (!$granted) {
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

                if (in_array("*", $request->getQueryParams()["fields"] ?? [])) {
                    $fields = array_merge($fields, $request->getQueryParams()["fields"] ?? []);
                } else {
                    $fields = $request->getQueryParams()["fields"] ?? $fields;
                }


                $data["data"] = $object->toArray($fields);
            } else {
                $data["data"] = $object;
            }




            $data["meta"] = $meta;

            return new JsonResponse($data);
        });


        $route->post($this->name, function (ServerRequestInterface $request, array $args) use ($rbac) {

            if (strstr($request->getHeaderLine("Content-Type"), "application/json")) {
                $user = $request->getAttribute(UserInterface::class);

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

        $route->post($this->name . "/{id:number}", function (ServerRequestInterface $request, array $args) {
            if (strstr($request->getHeaderLine("Content-Type"), "application/json")) {
                $user = $request->getAttribute(UserInterface::class);
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
                return new EmptyResponse(200, [
                    "Content-Location" => $object->uri()
                ]);
            }
            throw new NotFoundException();
        });

        $route->patch($this->name . "/{id:number}", function (ServerRequestInterface $request, array $args) {
            if (strstr($request->getHeaderLine("Content-Type"), "application/json")) {
                $user = $request->getAttribute(UserInterface::class);
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

        $rbac = $this->rbac;
        $route->delete($this->name . "/{id:number}", function (ServerRequestInterface $request, array $args) use ($rbac) {
            $user = $request->getAttribute(UserInterface::class);

            $object = $this->getObject($args["id"]);


            if (!$object) {
                throw new NotFoundException();
            }

            if (!$rbac->isGranted($user, "delete", $object)) {
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
            $data = $this->class::QueryData($query, $request->getAttribute(UserInterface::class));
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

    public function createObject(): ?ModelInterface
    {
        $class = $this->class;
        if (!$class) return null;
        return new $class;
    }

    public function getObject(int $id): ?ModelInterface
    {

        $class = $this->class;
        return $class::Get($id);
    }

    public function getMenuItemByUser(UserInterface $user): array
    {
        if ($this->hide) {
            return [];
        }

        $menus = [];
        $roles = $user->getRoles();


        foreach ($this->getMenus() as $menu) {

            if (!$this->security->isGranted($user, $menu->name ?? "")) {
                continue;
            }


            //$this->rbac->isGranted()
            /*      if (!$this->acl->isAllowed($user, $menu)) {
                continue;
            }
 */

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
