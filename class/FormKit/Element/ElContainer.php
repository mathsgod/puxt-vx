<?php

namespace FormKit\Element;

use FormKit\ComponentNode;


class ElContainer extends ComponentNode
{

    function addHeader(): ElHeader
    {
        return $this->appendHTML('<el-header></el-header>')[0];
    }

    function addMain(): ElMain
    {
        return $this->appendHTML('<el-main></el-main>')[0];
    }

    function addFooter(): ElFooter
    {
        return $this->appendHTML('<el-footer></el-footer>')[0];
    }

    function addAside(): ElAside
    {
        return $this->appendHTML('<el-aside></el-aside>')[0];
    }

    function addContainer(): ElContainer
    {
        return $this->appendHTML('<el-container></el-container>')[0];
    }

    function direction(string $direction)
    {
        $this->setAttribute('direction', $direction);
        return $this;
    }
}
