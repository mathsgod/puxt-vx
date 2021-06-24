<?php

namespace VX;

use Exception;
use Symfony\Component\Yaml\Yaml;

class Module
{
    public $name;
    public $class;
    public $icon = "far fa-circle";
    public $group;
    public $sequence = PHP_INT_MAX;
    public $hide = false;

    public $menu = [];

    public function __construct(string $name, array $config = [])
    {
        $this->name = $name;
        $this->class = $name;

        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
    }

    public function getFiles()
    {
        $files = [];

        $base = getcwd() . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR;
        $path = $base . "*";
        foreach (glob($path) as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            if ($ext != "php" && $ext != "twig") continue;

            $file = substr($file, 0, - (strlen($ext) + 1));

            $files[] = substr($file, strlen($base));
        }


        $base = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR;
        $path = $base . "*";
        foreach (glob($path) as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            if ($ext != "php" && $ext != "twig") continue;

            $file = substr($file, 0, - (strlen($ext) + 1));

            $files[] = substr($file, strlen($base));
        }


        return $files;
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
        try {
            $obj = new $class($id);
            return $obj;
        } catch (Exception $e) {
        }
    }

    public function getMenuItemByUser(User $user): array
    {
        $data = [];
        $data["label"] = $this->name;
        $data["icon"] = $this->icon;


        $submenu = $this->getMenuLinkByUser($user);

        $data["link"] = "#";

        if (count($submenu)) {
            $data["submenu"] = $submenu;


            if ($user->allow_uri($this->name . "/index")) {
                array_unshift($data["submenu"], [
                    "label" => "List",
                    "icon" => "fa fa-list",
                    "link" => "/" . $this->name
                ]);
            }
        } else {
            if ($user->allow_uri($this->name . "/index")) {
                $data["link"] = "/" . $this->name;
            }
        }



        return $data;
    }

    public function getMenuLinkByUser(User $user): array
    {

        $links = [];


        if ($this->show_create) {

            if ($user->allow_uri($this->name . "/ae")) {
                $link = [];
                $link["label"] = "Add";
                $link["icon"] = "fa fa-plus";
                $link["link"] = "/" . $this->name . "/ae";
                $links[] = $link;
            }
        }
        foreach ($this->menu as $m) {
            $link = $m;
            $links[] = $link;
        }
        return $links;
    }
}
