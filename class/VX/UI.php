<?php

namespace VX;

class UI
{

    public $vx;
    public function __construct(\VX $vx)
    {
        $this->vx = $vx;
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

    public function createView()
    {
        $view = new UI\View();
        $view->setData($this->vx->object());
        return $view;
    }

    public function createForm($data = null)
    {
        $form = new UI\Form;

        if ($obj = $this->vx->object()) {
            $action = "/" . $this->vx->module->name;
            if ($id = $obj->_id()) {
                $form->setAttribute("method", "patch");
                $action .= "/" . $id;
            } else {
                $form->setAttribute("method", "post");
            }
            $form->setAction($action);
        }

        if ($data) {
            $form->setData($data);
        } elseif ($obj = $this->vx->object()) {
            $form->setData($obj);
        }
        return $form;
    }

    public function createT($data)
    {

        $t = new UI\T;
        $t->setData($data);

        return $t;
    }

    public function createTab()
    {
        $tab = new UI\Tabs;


        $tab->setBaseURL("/" . dirname($this->vx->request_uri));

        return $tab;
    }

    public function createRTable(string $entry)
    {
        $rt = new UI\RTable();

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
}
