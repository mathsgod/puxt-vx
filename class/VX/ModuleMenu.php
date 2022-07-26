<?php

namespace VX;

use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use VX\UI\EL\MenuItem;

class ModuleMenu implements TranslatorAwareInterface, ResourceInterface
{

    public $link;
    public $label;
    public $icon;

    /**
     * @var ModuleMenu[]
     */
    public $menu = [];
    public $acl;
    public function __construct($data, ?AclInterface $acl)
    {
        $this->label = $data["label"];
        $this->icon = $data["icon"] ?? "link";
        $this->link = $data["link"];
        $this->acl = $acl;


        foreach ($data["menu"] as $m) {
            $mm = new ModuleMenu($m, $acl);
            $this->menu[] = $mm;
        }
    }

    protected $translator = null;

    public function getResourceId()
    {
        return substr($this->link, 1);
    }

    public function getMenuItems()
    {
        $items = [];
        foreach ($this->menu as $m) {
            $items[] = new MenuItem($m);
        }
        return $items;
    }

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
            $data["menus"] = [];
            foreach ($this->menu as $m) {
                if (!$this->acl->isAllowed($user, $m)) {
                    continue;
                }

                $data["menus"][] = $m->getMenuLinkByUser($user);
            }
        } else {
            $data["link"] = $this->link;
        }

        return $data;
    }

    public function isAllow($user)
    {
    }
}
