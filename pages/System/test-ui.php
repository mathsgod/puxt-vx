<vue>
    <el-card class="mb-2">
        <?php

        use VX\UI\EL\Collapse;

        $collapse = new Collapse;
        $collapse->setAccordion(true);
        $item = $collapse->addItem();

        $item->setTitle("Alert test");

        use VX\UI\EL\Alert;

        $alert = new Alert();
        $alert->classList->add("mb-1");
        $alert->setShowIcon(true);
        $alert->setType("success");
        $alert->setTitle("alert title");
        $alert->setDescription("alert description");
        $item->append($alert);


        echo $collapse;



        ?>
    </el-card>

    <div class="d-flex flex-column">
        <router-link to="/System/test-table">Table</router-link>
        <router-link to="/System/test-button">Button</router-link>
        <router-link to="/System/test-form">Form</router-link>
        <router-link to="/System/test-descriptions">Descriptions</router-link>
        <router-link to="/System/test-input-xlsx">Input-xlsx</router-link>
        <router-link to="/System/test-progress">Progress</router-link>

    </div>
</vue>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-10-18 
 */
return new class
{
    function get(VX $vx)
    {
    }
};
