<?php

namespace VX;

use Symfony\Contracts\Translation\TranslatorInterface;
use VX\Security\AssertionInterface;
use VX\Security\Security;
use VX\Security\UserInterface;

class ModuleMenu implements TranslatorAwareInterface, AssertionInterface
{

    public $link;
    public $label;
    public $icon;
    public $name;

    /**
     * @var ModuleMenu[]
     */
    public $menu = [];
    public function __construct($data)
    {
        $this->name = substr($data["link"], 1);
        $this->name = $data["name"];
        $this->label = $data["label"];
        $this->icon = $data["icon"] ?? "link";
        $this->link = $data["link"];

        foreach ($data["menu"] as $m) {
            $mm = new ModuleMenu($m);
            $this->menu[] = $mm;
        }
    }

    protected $translator = null;

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

    public function getName()
    {
        $name = substr($this->link, 0, 1) == "/" ? $link = substr($this->link, 1) : $this->link;
        return "menu.{$name}";
    }


    public function getMenuLinkByUser(UserInterface $user, Security $security)
    {
        $data = [];

        $data["name"] = $this->name;
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
