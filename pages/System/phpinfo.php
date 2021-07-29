<div id="phpinfo">
    {{pinfo|raw}}
</div>
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-29 
 */
return new class
{
    function get(VX $vx)
    {

        ob_start();
        phpinfo();
        $pinfo = ob_get_contents();
        ob_end_clean();
        $pinfo = str_replace("module_Zend Optimizer", "module_Zend_Optimizer", preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo));

        $p = p($pinfo);
        $p->find("table")->addClass("table");

        $this->pinfo = (string)$p;
    }
};
