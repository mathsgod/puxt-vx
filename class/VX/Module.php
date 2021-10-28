<?php

namespace VX;

use Exception;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Symfony\Component\Yaml\Yaml;

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

    public function __construct(string $name, ?array $config = [])
    {
        $this->name = $name;
        $this->class = $name;

        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
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

        $files = [];


        $path = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . "*";
        foreach (glob($path) as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($ext != "php" && $ext != "twig") continue;
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $files[$filename] = new ModuleFile($this, $file);
        }

        $path = getcwd() . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . "*";
        foreach (glob($path) as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($ext != "php" && $ext != "twig") continue;
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $files[$filename] = new ModuleFile($this, $file);
        }

        return array_values($files);
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
}
