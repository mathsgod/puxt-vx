<?php

namespace FormKit\Element;

use FormKit\Element\Inputs\ElInput;
use FormKit\Element\Inputs\ElSelect;

trait ElementTrait
{

    function addElSelect(?string $label = null, string $name): ElSelect
    {
        $select = $this->appendHTML('<form-kit type="el-select"></form-kit>')[0];

        if ($label) {
            $select->label($label);
        }

        if ($name) {
            $select->name($name);
        }

        return $select;
    }

    function addElInput(?string $label = null, string $name): ElInput
    {
        $input = $this->appendHTML('<form-kit type="el-input"></form-kit>')[0];

        if ($label) {
            $input->label($label);
        }

        if ($name) {
            $input->name($name);
        }

        return $input;
    }


    function addElText(): ElText
    {
        return $this->appendHTML('<el-text></el-text>')[0];
    }

    function addElSteps(): ElSteps
    {
        return $this->appendHTML('<el-steps></el-steps>')[0];
    }

    function addElPageHeader(): ElPageHeader
    {
        return $this->appendHTML('<el-page-header></el-page-header>')[0];
    }

    function addElBreadcrumb(): ElBreadcrumb
    {
        return $this->appendHTML('<el-breadcrumb></el-breadcrumb>')[0];
    }

    function addElBacktop(): ElBacktop
    {
        return $this->appendHTML('<el-backtop></el-backtop>')[0];
    }

    function addElAffix(): ElAffix
    {
        return $this->appendHTML('<el-affix></el-affix>')[0];
    }

    function addElTimeline(): ElTimeline
    {
        return $this->appendHTML('<el-timeline></el-timeline>')[0];
    }

    function addElSkeleton(): ElSkeleton
    {
        return $this->appendHTML('<el-skeleton></el-skeleton>')[0];
    }

    function addElProgress(): ElProgress
    {
        return $this->appendHTML('<el-progress></el-progress>')[0];
    }

    function addElImage(): ElImage
    {
        return $this->appendHTML('<el-image></el-image>')[0];
    }

    function addElAvatar(): ElAvatar
    {
        return $this->appendHTML('<el-avatar></el-avatar>')[0];
    }

    function addElContainer(): ElContainer
    {
        return $this->appendHTML('<el-container></el-container>')[0];
    }

    function addElScrollbar(): ElScrollbar
    {
        return $this->appendHTML('<el-scrollbar></el-scrollbar>')[0];
    }

    function addElTabs(): ElTabs
    {
        return $this->appendHTML('<el-tabs></el-tabs>')[0];
    }

    function addElTable(): ElTable
    {
        return $this->appendHTML('<el-table></el-table>')[0];
    }

    function addElRow(): ElRow
    {
        return $this->appendHTML('<el-row></el-row>')[0];
    }
    function addElCollapse(): ElCollapse
    {
        return $this->appendHTML('<el-collapse></el-collapse>')[0];
    }

    function addElResult(): ElResult
    {
        return $this->appendHTML('<el-result></el-result>')[0];
    }

    function addElEmpty(): ElEmpty
    {
        return $this->appendHTML('<el-empty></el-empty>')[0];
    }

    function addElLink(): ElLink
    {
        return $this->appendHTML('<el-link></el-link>')[0];
    }

    function addElSpace(): ElSpace
    {
        return $this->appendHTML('<el-space></el-space>')[0];
    }

    function addElDivider(): ElDivider
    {
        return $this->appendHTML('<el-divider></el-divider>')[0];
    }

    function addElBadge(): ElBadge
    {
        return $this->appendHTML('<el-badge></el-badge>')[0];
    }

    function addElDescriptions(): ElDescriptions
    {
        return $this->appendHTML('<el-descriptions></el-descriptions>')[0];
    }

    function addElStatistic(): ElStatistic
    {
        return $this->appendHTML('<el-statistic></el-statistic>')[0];
    }

    function addElTag(): ElTag
    {
        return $this->appendHTML('<el-tag></el-tag>')[0];
    }


    function addElCard(): ElCard
    {
        return $this->appendHTML('<el-card></el-card>')[0];
    }

    function addElButton(): ElButton
    {
        return $this->appendHTML('<el-button></el-button>')[0];
    }

    function addElMenu(): ElMenu
    {
        return $this->appendHTML('<el-menu></el-menu>')[0];
    }

    function addElCountdown(): ElCountdown
    {
        return $this->appendHTML('<el-countdown></el-countdown>')[0];
    }
    
    function addElTree(?string $name): ElTree
    {
        $tree = $this->appendHTML('<el-tree></el-tree>')[0];
    /*     if ($name) {
            $tree->name($name);
        } */
        return $tree;
    }
}
