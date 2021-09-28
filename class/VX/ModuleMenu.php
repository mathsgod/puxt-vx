<?php

namespace VX;

use Symfony\Contracts\Translation\TranslatorInterface;

class ModuleMenu implements TranslatorAwareInterface
{

    public $link;
    public $label;
    public $icon;
    public $menu = [];
    public function __construct($data)
    {
        $this->label = $data["label"];
        $this->icon = $data["icon"];
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


    public function getMenuLinkByUser(User $user)
    {
        $data = [];

        $data["name"] = $this->label;
        $data["label"] = $this->translator ? $this->translator->trans($this->label) : $this->label;
        $data["icon"] = $this->icon;
        $data["link"] = "#";

        if ($this->menu) {
            $data["submenu"] = [];
            foreach ($this->menu as $m) {
                $data["submenu"][] = $m->getMenuLinkByUser($user);
            }
        } else {
            $data["link"] = $this->link;
        }

        return $data;
    }
}
