<?php

namespace VX;

use Symfony\Contracts\Translation\TranslatorInterface;
use VX\Security\AssertionInterface;
use VX\Security\Security;
use VX\Security\UserInterface;

class ModuleMenu implements AssertionInterface
{

    public $link;
    public $label;
    public $icon;
    public $name;

    /**
     * @var ModuleMenu[]
     */
    public $menu = [];
    protected $translator;

    public function __construct($data, TranslatorInterface $translator)
    {
        $this->name = substr($data["link"], 1);
        $this->label = $translator->trans($data["label"]);
        $this->icon = $data["icon"] ?? "link";
        $this->link = $data["link"];

        foreach ($data["menu"] as $m) {
            $mm = new ModuleMenu($m, $translator);
            $this->menu[] = $mm;
        }
        $this->translator = $translator;
    }


    function assert(Security $security, UserInterface $user, string $permission): bool
    {
        if ($user->is("Administrators")) {
            return true;
        }
        return $security->isGranted($user, $permission);
    }


    public function setTranslator(TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
        foreach ($this->menu as $menu) {
            $menu->setTranslator($translator);
        }
    }

    public function getPermission()
    {
        $permission = [];
        if ($this->getName()) {
            $permission["value"] = $this->getName();
        }

        $permission["label"] = $this->label;
        $permission["children"] = array_map(function ($m) {
            return $m->getPermission();
        }, $this->menu);
        return $permission;
    }

    public function getName()
    {
        if (!$this->link) return null;

        $name = substr($this->link, 1);
        //explode first /
        $strs = explode("/", $name, 2);
        return $strs[0] . "/[menu]/" . $strs[1];
    }


    public function getMenuLinkByUser(UserInterface $user, Security $security)
    {
        $data = [];

        $data["label"] = $this->translator ? $this->translator->trans($this->label) : $this->label;
        $data["icon"] = $this->icon;
        $data["link"] = "#";


        if ($this->menu) {
            $data["menus"] = [];

            foreach ($this->menu as $m) {

                if (!$security->isGranted($user, $m->getName(), $m)) {
                    continue;
                };

                $data["menus"][] = $m->getMenuLinkByUser($user, $security);
            }
        } else {
            $data["link"] = $this->link;
        }

        return $data;
    }
}
