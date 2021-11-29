<?php

namespace VX;

use Exception;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;
use League\Route\Router;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Yaml\Yaml;
use VX;

class Module implements TranslatorAwareInterface, ResourceInterface
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
                    return $ext == "php" || $ext == "twig";
                })->toArray();

                foreach ($files as $file) {

                    $ext = pathinfo($file["path"], PATHINFO_EXTENSION);
                    $path = substr($file["path"], 0, - (strlen($ext) + 1));

                    $this->files[$path] = new ModuleFile($this, $this->name . "/" . $path, $b . DIRECTORY_SEPARATOR . $path);
                }
            }

            //load config 
            if (file_exists($b . DIRECTORY_SEPARATOR . "setting.yml")) {
                $config = Yaml::parseFile($b . DIRECTORY_SEPARATOR . "setting.yml");
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
            }
        }



        $this->files = array_values($this->files);
    }

    private function getModuleFile(string $path)
    {
        foreach ($this->files as $file) {
            if ($file->path == $path) {
                return $file;
            }
        }
    }

    function getRouterMap()
    {


        $map = [];

        if ($module_file = $this->getModuleFile($this->name . "/index")) {
            $map[] = [
                "method" => "GET",
                "path" => $this->name,
                "handler" => $module_file
            ];
        }


        foreach ($this->files as $file) {
            $map[] = [
                "method" => "GET",
                "path" => $file->path,
                "handler" => $file
            ];
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

    public function getObject(int $id): IModel
    {
        $class = $this->class;
        return $class::Load($id);
    }

    public function getMenuItemByUser(User $user): array
    {
        if ($this->hide) {
            return [];
        }
        $data = [];
        $data["label"] = $this->translator->trans($this->name);
        $data["icon"] = $this->icon;


        $submenu = $this->getMenuLinkByUser($user);

        $data["link"] = "#";
        $data["name"] = $this->name;

        if (count($submenu)) {
            $data["submenu"] = $submenu;

            if ($this->acl->isAllowed($user, $this->name . "/index")) {
                array_unshift($data["submenu"], [
                    "label" => $this->translator->trans("List"),
                    "icon" => "fa fa-list",
                    "link" => "/" . $this->name
                ]);
            }
        } else {
            if ($this->acl->isAllowed($user, $this->name . "/index")) {
                $data["link"] = "/" . $this->name;
            } else {
                return [];
            }
        }



        return $data;
    }

    public function getMenuLinkByUser(User $user): array
    {

        $links = [];


        if ($this->show_create) {
            if ($this->acl->isAllowed($user, $this->name . "/ae")) {
                $link = [];
                $link["label"] = $this->translator->trans("Add");
                $link["icon"] = "fa fa-plus";
                $link["link"] = "/" . $this->name . "/ae";
                $links[] = $link;
            }
        }
        foreach ($this->menu as $m) {
            if (!$this->acl->isAllowed($user, substr($m["link"], 1))) {
                continue;
            }
            $mm = new ModuleMenu($m);
            $mm->setTranslator($this->translator);
            $links[] = $mm->getMenuLinkByUser($user);
        }
        return $links;
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
