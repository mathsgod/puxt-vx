{% verbatim %}
<div id="div1">

    <el-card :header="$t('Permissions')">
        <p>Permission according to roles</p>

        <el-form inline>
            <el-form-item :label="$t('User group')">
                <el-select v-model="usergroup_id" clearable>
                    <el-option v-for="ug in UserGroup" :value="ug.usergroup_id" :label="ug.name" :key="ug.usergroup_id"></el-option>
                </el-select>
            </el-form-item>

            <el-form-item v-if="usergroup_id">
                <el-button @click="exportXlsx">Export</el-button>
            </el-form-item>
        </el-form>

        <el-table :data="items" stripe>
            <el-table-column type="expand">
                <template slot-scope="props">
                    <el-table :data="props.row.files">
                        <el-table-column label="Name" prop="name"></el-table-column>
                        <el-table-column label="Allow">
                            <template slot-scope="scope">
                                <el-checkbox v-model="scope.row.allow.checked" :disabled="scope.row.allow.disabled" @input="changePathValue(props.row.name,scope.row.name,'allow',scope.row.allow.checked)"></el-checkbox>
                            </template>
                        </el-table-column>
                        <el-table-column label="Deny">
                            <template slot-scope="scope">
                                <el-checkbox v-model="scope.row.deny.checked" :disabled="scope.row.deny.disabled" @input="changePathValue(props.row.name,scope.row.name,'deny',scope.row.deny.checked)"></el-checkbox>
                            </template>

                        </el-table-column>
                    </el-table>


                </template>
            </el-table-column>
            <el-table-column label="Module" prop="name"></el-table-column>
            <el-table-column label="Full Control">
                <template slot-scope="scope">
                    <el-checkbox v-model="scope.row.all.value" :disabled="scope.row.all.disabled" @input="changeValue(scope.row.name,'all')"></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column label="Create">
                <template slot-scope="scope">
                    <el-checkbox v-model="scope.row.create.value" :disabled="scope.row.create.disabled" @input="changeValue(scope.row.name,'create')"></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column label="Read">
                <template slot-scope="scope">
                    <el-checkbox v-model="scope.row.read.value" :disabled="scope.row.read.disabled" @input="changeValue(scope.row.name,'read')"></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column label="Write">
                <template slot-scope="scope">
                    <el-checkbox v-model="scope.row.update.value" :disabled="scope.row.update.disabled" @input="changeValue(scope.row.name,'update')"></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column label="Delete">
                <template slot-scope="scope">
                    <el-checkbox v-model="scope.row.delete.value" :disabled="scope.row.delete.disabled" @input="changeValue(scope.row.name,'delete')"></el-checkbox>
                </template>
            </el-table-column>
        </el-table>
    </el-card>
</div>
{% endverbatim %}

<script>
    new Vue({
        i18n,
        el: "#div1",
        data() {
            return {
                usergroup_id: null,
                UserGroup: [],
                items: null
            }
        },
        async created() {
            this.UserGroup = (await this.$vx.get("/ACL/all?_entry=getUserGroup")).data;


        },
        watch: {
            async usergroup_id() {
                if (!this.usergroup_id) {
                    this.items = [];
                    return;
                }

                let resp = (await this.$vx.get("/ACL/all", {
                    params: {
                        _entry: "getACL",
                        usergroup_id: this.usergroup_id
                    }
                })).data;
                this.items = resp;
            }
        },
        methods: {
            exportXlsx() {
                window.self.location = vx.endpoint + "ACL/all?usergroup_id=" + this.usergroup_id + "&_entry=getXlsx&_token=" + vx.accessToken;
            },
            async changePathValue(module, path, value, checked) {
                let resp = await this.$vx.post("/ACL/all", {
                    usergroup_id: this.usergroup_id,
                    module,
                    path,
                    value,
                    checked: checked,
                    type: "path"
                });
            },
            async changeValue(module, action) {
                let items = this.items.filter(item => item.name == module)[0];

                let resp = await this.$vx.post("/ACL/all", {
                    usergroup_id: this.usergroup_id,
                    module,
                    action,
                    value: items[action].value
                });

            }
        },
    });
</script>
<?php

use Symfony\Component\Yaml\Parser;
use VX\ACL;
use VX\Module;
use VX\UserGroup;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Protection;

return new class
{

    function getXlsx(VX $vx)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray(["Module", "URL", "Full control", "Create", "Read", "Write", "Delete", "Allow", "Deny"]);
        $sheet->getColumnDimensionByColumn(1)->setWidth(15);
        $sheet->getColumnDimensionByColumn(2)->setWidth(25);
        $sheet->freezePane("A2");

        $ret = $this->getACL($vx);

        $row = 2;
        foreach ($ret as $r) {
            $d = [];
            $d[] = $r["name"];
            $d[] = "";
            $d[] = $r["all"]["value"] ? "???" : "";
            $d[] = $r["create"]["value"] ? "???" : "";
            $d[] = $r["read"]["value"] ? "???" : "";
            $d[] = $r["update"]["value"] ? "???" : "";
            $d[] = $r["delete"]["value"] ? "???" : "";

            $sheet->fromArray($d, null, "A$row");


            $sheet->getStyle("C$row:G$row")->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
            $sheet->getStyle("C$row:G$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("H$row:I$row")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB("eeeeee");

            $row++;

            foreach ($r["files"] as $f) {
                $d = [];
                $d[] = "";
                $d[] = $f["name"];
                $d[] = "";
                $d[] = "";
                $d[] = "";
                $d[] = "";
                $d[] = "";
                $d[] = $f["allow"]["checked"] ? "???" : "";
                $d[] = $f["deny"]["checked"] ? "???" : "";

                $sheet->fromArray($d, null, "A$row");
                $sheet->getStyle("H$row:I$row")->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
                $sheet->getStyle("H$row:I$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C$row:G$row")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB("eeeeee");


                $row++;
            }
        }

        $sheet->getProtection()->setSheet(true);

        $filename = "acl.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save("php://output");
        die();
    }

    function post(VX $vx)
    {
        $post = $vx->_post;


        if ($post["type"] == "path") {
            $acl = ACL::Query([
                "usergroup_id" => $post["usergroup_id"],
                "module" => $post["module"],
                "path" => $post["path"],
                "value" => $post["value"]
            ])->first();

            if ($post["checked"]) {
                if (!$acl) $acl = new ACL();
                $acl->usergroup_id = $post["usergroup_id"];
                $acl->module = $post["module"];
                $acl->path = $post["path"];
                $acl->value = $post["value"];
                $acl->save();
            } else {
                if ($acl) $acl->delete();
            }


            http_response_code(204);
            return;
        }

        $acl = ACL::Query([
            "usergroup_id" => $post["usergroup_id"],
            "module" => $post["module"],
            "action" => $post["action"],
            "value" => "allow"
        ])->first();

        if ($post["value"]) {
            if (!$acl) $acl = new ACL();

            $acl->usergroup_id = $post["usergroup_id"];
            $acl->module = $post["module"];
            $acl->action = $post["action"];
            $acl->value = "allow";

            $acl->save();
        } else {
            if ($acl) {
                $acl->delete();
            }
        }

        http_response_code(204);
    }


    function getUserGroup()
    {
        return UserGroup::Query()->toArray();
    }

    function getACL(VX $vx)
    {
        $usergroup = UserGroup::Get($vx->_get["usergroup_id"]);

        $ret = [];
        $acl = $vx->getAcl();

        foreach ($vx->getModules() as $module) {

            $r = [];
            $r["name"] = $module->name;

            $r["all"] = [
                "value" => $acl->isAllowed($usergroup, $module),
                "disabled" => $this->getACLPreset($usergroup, $module, "all")
            ];
            $r["create"] = [
                "value" => $acl->isAllowed($usergroup, $module, "create"),
                "disabled" => $this->getACLPreset($usergroup, $module, "create")
            ];
            $r["read"] = [
                "value" => $acl->isAllowed($usergroup, $module, "read"),
                "disabled" => $this->getACLPreset($usergroup, $module, "read")
            ];
            $r["update"] = [
                "value" => $acl->isAllowed($usergroup, $module, "update"),
                "disabled" => $this->getACLPreset($usergroup, $module, "update")
            ];
            $r["delete"] = [
                "value" => $acl->isAllowed($usergroup, $module, "delete"),
                "disabled" => $this->getACLPreset($usergroup, $module, "delete")
            ];

            $r["files"] = [];

            foreach ($module->getFiles() as $file) {
                $r["files"][] = [
                    "name" => $file->path,
                    "allow" => [
                        "checked" => $this->getACLPathValue($usergroup, $module, $file->path, "allow"),
                        "disabled" => $this->getACLPathPreset($usergroup, $module, $file->path, "allow")
                    ],
                    "deny" => [
                        "checked" => $this->getACLPathValue($usergroup, $module, $file->path, "deny"),
                        "disabled" => $this->getACLPathPreset($usergroup, $module, $file->path, "deny")
                    ]
                ];
            }

            $ret[] = $r;
        }

        return $ret;
    }

    private function getACLPathPreset(UserGroup $usergroup, Module $module, string $path, string $value)
    {
        if ($usergroup->name == "Administrators") {
            return true;
        }

        $yml = new Parser();
        $acl = $yml->parseFile(dirname(__DIR__, 2) . "/acl.yml");
        $allow_ug = $acl["path"][$module->name][$path];

        return in_array($usergroup->name, $allow_ug ?? []);
    }

    private function getACLPathValue(UserGroup $usergroup, Module $module, string $path, string $value)
    {

        if ($usergroup->name == "Administrators") {
            if ($value == "allow") {
                return true;
            }

            if ($value == "deny") {
                return false;
            }
        }

        $yml = new Parser();
        $acl = $yml->parseFile(dirname(__DIR__, 2) . "/acl.yml");
        $allow_ug = $acl["path"][$module->name][$path];
        if (in_array($usergroup->name, $allow_ug ?? [])) {
            return true;
        }


        $a = ACL::Query([
            "usergroup_id" => $usergroup->usergroup_id,
            "module" => $module->name,
            "path" => $path,
            "value" => $value
        ])->count();

        if ($a) return true;
        return false;
    }



    function getACLPreset(UserGroup $usergroup, Module $module, string $action)
    {
        if ($usergroup->name == "Administrators") {
            return true;
        }

        $yml = new Parser();
        $acl = $yml->parseFile(dirname(__DIR__, 2) . "/acl.yml");
        return in_array($usergroup->name,  $acl["action"][$action][$module->name] ?? []);
    }
};
