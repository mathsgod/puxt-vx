<?php

namespace VX;

use Symfony\Contracts\Translation\TranslatorInterface;
use VX\Authentication\UserInterface;

class ModuleMenu implements TranslatorAwareInterface
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


    public function setTranslator(TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
        foreach ($this->menu as $menu) {
            $menu->setTranslator($translator);
        }
    }


    public function getMenuLinkByUser(UserInterface $user)
    {
        $data = [];

        $data["name"] = $this->label;
        $data["label"] = $this->translator ? $this->translator->trans($this->label) : $this->label;
        $data["icon"] = $this->icon;
        $data["link"] = "#";

        
        if ($this->menu) {
            $data["menus"] = [];

            foreach ($this->menu as $m) {
                
                /*   if (!$this->acl->isAllowed($user, $m)) {
                    continue;
                } */

                $data["menus"][] = $m->getMenuLinkByUser($user);
            }
        } else {
            $data["link"] = $this->link;
        }

        return $data;
    }
}
