<vue>

    <div class="d-flex flex-column">
        <router-link to="/System/test-table">Table</router-link>
        <router-link to="/System/test-button">Button</router-link>
        <router-link to="/System/test-form">Form</router-link>
        <router-link to="/System/test-descriptions">Descriptions</router-link>
        <router-link to="/System/test-input-xlsx">Input-xlsx</router-link>
        <router-link to="/System/test-progress">Progress</router-link>

    </div>

    <?php

    use VX\UI\EL\Alert;

    $alert = new Alert();
    $alert->setTitle("alert title");
    $alert->setDescription("alert description");
    echo $alert;
    ?>

    <?php

    $alert = new Alert();
    $alert->setTitle("alert title");
    $alert->setDescription("alert description");
    echo $alert;
    ?>
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
