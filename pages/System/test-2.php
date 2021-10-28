{{ta|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-10-28 
 */

use P\HTMLTemplateElement;
use VX\User;
use VX\UserGroup;

return new class
{
    function get(VX $vx)
    {

        $ta = $vx->ui->createTable("getAData");

        $ta->addExpand("")->append($this->getTableB($vx));
        $ta->add("First name", "first_name");
        $ta->add("")->template(function (HTMLTemplateElement $template) {
            $template->innerHTML = "<div><el-button>aaa</el-button></div>";
        });



        $this->ta = $ta;
    }

    function getAData(VX $vx)
    {

        $resp = $vx->ui->createTableResponse();
        $resp->setSource(User::Query());
        return $resp;
    }

    function getTableB(VX $vx)
    {
        $tb = $vx->ui->createTable("getTableBData");
        $tb->setPagination(false);
        $tb->setAttribute(":remote", '`/System/test-2?_entry=getTableBData`');

        $tb->add("USER GROUP ID", "usergroup_id")->sortable();
        $tb->add("")->template(function (HTMLTemplateElement $template) {
            $template->innerHTML = "<el-button>bbb</el-button>";
        });
        $tb->add("")->template(function (HTMLTemplateElement $template) {
            $template->innerHTML = "<div><router-link to='/User/ae'>user</router-link></div>";
        });
        return $tb;
    }

    function getTableBData(VX $vx)
    {

        $resp = $vx->ui->createTableResponse();
        $resp->setSource(UserGroup::Query());
        return $resp;
    }
};
