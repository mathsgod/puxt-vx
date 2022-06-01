<div>
    <el-card id="card1" class="mb-2">
        {{view|raw}}


        <el-button @click="change">Change to utf8mb4</el-button>

        <el-button @click="change_column">Change all column to table default</el-button>
    </el-card>
</div>

<script>
    Vue.createApp({
        el: "#card1",
        methods: {
            async change() {
                let {
                    data,
                    status
                } = await this.$vx.post(this.$vx.$route.path);

                if (data.error) {
                    this.$message.error(data.error.message);
                    return;
                }

                if (status == 200) {
                    this.$message("Update successfully");
                    return;
                }
            },
            async change_column() {
                let {
                    data,
                    status
                } = await this.$vx.post(this.$vx.$route.path + "?_entry=change_column");
                if (data.error) {
                    this.$message.error(data.error.message);
                    return;
                }

                if (status == 200) {
                    this.$message("Update successfully");
                    return;
                }
            }

        },

    })
</script>

<div>
{{table|raw}}
</div>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-16 
 */

use VX\UI\EL\Table;

return new class
{
    function change_column(VX $vx)
    {
        $error = [];

        foreach ($vx->getDB()->getTables() as $table) {
            foreach ($table->columns() as $column) {
                if (
                    strtolower(substr($column->Type, 0, 7)) == "varchar" ||
                    strtolower($column->Type) == "text" ||
                    strtolower($column->Type) == "longtext"
                ) {

                    $field = $column->Field;
                    $type = $column->Type;
                    $t = $table->name;
                    $sql = "ALTER TABLE  `$t` CHANGE COLUMN `{$field}` `{$field}` {$type} NULL DEFAULT NULL;";

                    try {
                        $vx->getDB()->exec($sql);
                    } catch (Exception $e) {
                        $error[] = $sql;
                        $error[] = $e->getMessage();
                    }
                }
            }
        }
        if ($error) {
            return ["error" => [
                "message" => implode("\n", $error)
            ]];
        }
    }

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
        $view = $vx->ui->createDescriptions($data);
        $view->add("Current database character set", "@@character_set_database");
        $view->add("Current database collation", "@@collation_database");
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
