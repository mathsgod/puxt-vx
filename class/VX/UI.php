<?php

namespace VX;

use Stringable;
use VX;
use VX\UI\Link;
use VX\UI\Table;

class UI implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;
    public $vx;
    public function __construct(VX $vx)
    {
        $this->vx = $vx;
    }

    function createMenu()
    {
        $menu = new UI\Menu;
        $menu->setMode("horizontal");
        $menu->setAttribute("router", true);
        return $menu;
    }

    public function createLink($obj, string $uri)
    {
        $link = new Link;
        if ($obj instanceof IModel) {
            if ($obj instanceof Stringable) {
                $link->textContent = $obj->__toString();
            }
            //$link->setHref($obj->uri($uri));
            $uri = $obj->uri($uri);
            $link->setAttribute("v-on:click", 'vx.$router.push(\'' . $uri . '\')');
        }
        return $link;
    }

    public function createTable(?string $entry = null)
    {
        $table = new Table;

        $table->setTranslator($this->translator);
        $table->setVX($this->vx);

        if ($entry) {
            $query = $this->vx->request->getQueryParams();
            $query["_entry"] = $entry;

            $uri = $this->vx->request_uri;
            if (strstr($uri, "/") == false) {
                $uri .= "/index";
            }

            $remote = "/" .    $uri . "?" . http_build_query($query);

            $table->setAttribute("remote", $remote);
        }

        $user = $this->vx->user;
        if (is_array($user->style)) {
            if ($user->style["table_size"]) {
                $table->setSize($user->style["table_size"]);
            }

            if ($user->style["table_border"] !== null) {
                $table->setBorder($user->style["table_border"]);
            }
        }

        return $table;
    }

    public function createFormTable($data, string $data_key, string $data_name = "data")
    {
        $t = new UI\FormTable;
        $t->setAttribute("data-key", $data_key);
        $t->setAttribute("data-name", $data_name);

        if ($data) {
            $t->setAttribute(":data", json_encode($data));
        }
        return $t;
    }


    /**
     * @deprecated Use createDescriptions
     */
    public function createView($object = null)
    {
        $view = new UI\View();
        $view->setTranslator($this->translator);


        if (is_null($object)) {
            $object = $this->vx->object();
        }
        $view->setData($object);


        return $view;
    }

    public function createForm($data = null)
    {
        $form = new UI\Form($this->vx);
        $form->setTranslator($this->translator);

        $user = $this->vx->user;
        if (is_array($user->style)) {
            if ($user->style["form_size"]) {
                $form->setAttribute("size", $user->style["form_size"]);
            }
        }

        if ($obj = $this->vx->object()) {
            $action = "/" . $this->vx->module->name;
            if ($id = $obj->_id()) {
                $form->setAttribute("method", "patch");
                $action .= "/" . $id;
            } else {
                $form->setAttribute("method", "post");
            }
            $form->setAction($action);

            $form->setSuccessUrl("/" . $this->vx->module->name);
        }

        if ($data) {
            $form->setData($data);
        } elseif ($obj = $this->vx->object()) {
            $form->setData($obj);
        }


        return $form;
    }

    public function createT(iterable $data)
    {

        $t = new UI\T;
        $t->setTranslator($this->translator);
        $t->setData($data);
        $t->setUser($this->vx->user);

        return $t;
    }


    public function createTabs()
    {

        $tab = new UI\Tabs;


        $tab->setBaseURL("/" . dirname($this->vx->request_uri));

        return $tab;
    }

    /**
     * @deprecated Use createTabs
     */
    public function createTab()
    {
        return $this->createTabs();
    }

    public function createRTable(string $entry)
    {
        $rt = new UI\RTable();

        $user = $this->vx->user;
        if ($user->style["rtable_size"]) {
            $rt->setAttribute("size", $user->style["rtable_size"]);
        }

        if ($user->style["rtable_small_table"]) {
            $rt->setAttribute("small-table", true);
        }

        $query = $this->vx->req->getQueryParams();
        $query["_entry"] = $entry;


        $remote = "/" .    $this->vx->request_uri . "?" . http_build_query($query);

        $rt->setAttribute("remote", $remote);

        return $rt;
    }

    public function createRTableResponse()
    {
        return new UI\RTableResponse($this->vx, $this->vx->query);
    }

    public function createTableResponse(\R\DB\Query $source = null)
    {
        $resp = new UI\TableResponse($this->vx, $this->vx->query);
        if ($source) {
            $resp->setSource($source);
        }


        return $resp;
    }

    public function createDescriptions($object = null)
    {
        $d = new UI\Descriptions;
        $d->setTranslator($this->translator);

        $user = $this->vx->user;
        if (is_array($user->style)) {
            if ($user->style["description_border"]) {
                $d->setBorder(true);
            }

            if ($user->style["description_size"]) {
                $d->setSize($user->style["description_size"]);
            }
        }



        if (is_null($object)) {
            $object = $this->vx->object();
        }
        $d->setData($object);
        return $d;
    }
}
