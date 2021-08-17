<el-card id="card1" class="mb-2">
    {{view|raw}}


    <el-button @click="change">Change to utf8mb4</el-button>
</el-card>


<script>
    new Vue({
        el: card1,
        methods: {
            async change() {
                let {
                    data
                } = await this.$vx.post(this.$vx.$route.path);

                if (data.error) {
                    alert(data.error.message);
                }

            }
        },

    })
</script>

{{table|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-16 
 */

use VX\UI\EL\Table;

return new class
{
    function post(VX $vx)
    {
        $charset = "utf8mb4";
        $collation = "utf8mb4_general_ci";

        $error = [];
        foreach ($vx->getDB()->getTables() as $table) {
            $t = $table->name;
            $sql = "ALTER TABLE  `$t` DEFAULT CHARACTER SET {$charset} COLLATE {$collation};";
            try {
                $vx->getDB()->exec($sql);
            } catch (Exception $e) {
                $error[] = $e->getMessage();
            }
        }

        if ($error) {
            return ["error" => [
                "message" => implode("\n", $error)
            ]];
        }
    }

    function get(VX $vx)
    {
        $data = $vx->getDB()->query("SELECT @@character_set_database, @@collation_database")->fetch();
        $view = $vx->ui->createView($data);
        $view->add("Current database character set", "@@character_set_database");
        $view->add("Current database collaction", "@@collation_database");
        $this->view = $view;


        $table = new Table;
        $table->setSize($table::SIZE_MINI);
        $table->setData($vx->getDB()->query("SHOW TABLE STATUS")->fetchAll());

        $table->addColumn("Name", "Name");
        $table->addColumn("Engine", "Engine");
        $table->addColumn("Collation", "Collation");
        $table->addColumn("Rows", "Rows");
        $table->addColumn("Data length", "Data_length");
        $this->table = $table;
    }
};
