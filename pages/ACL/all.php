<div id="div1">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Permissions</h4>
        </div>
        <p class="card-text ml-2">Permission according to roles</p>

        <el-form class="ml-2">
            <el-form-item label="User Group">
                <el-select v-model="usergroup_id" clearable>
                    <el-option v-for="ug in UserGroup" :value="ug.usergroup_id" :label="ug.name" :key="ug.usergroup_id"></el-option>
                </el-select>
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
                    <el-checkbox v-model="scope.row.FC.value" :disabled="scope.row.FC.disabled" @input="changeValue(scope.row.name,'FC')"></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column label="Create">
                <template slot-scope="scope">
                    <el-checkbox v-model="scope.row.C.value" :disabled="scope.row.C.disabled" @input="changeValue(scope.row.name,'C')"></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column label="Read">
                <template slot-scope="scope">
                    <el-checkbox v-model="scope.row.R.value" :disabled="scope.row.R.disabled" @input="changeValue(scope.row.name,'R')"></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column label="Write">
                <template slot-scope="scope">
                    <el-checkbox v-model="scope.row.U.value" :disabled="scope.row.U.disabled" @input="changeValue(scope.row.name,'U')"></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column label="Delete">
                <template slot-scope="scope">
                    <el-checkbox v-model="scope.row.D.value" :disabled="scope.row.D.disabled" @input="changeValue(scope.row.name,'D')"></el-checkbox>
                </template>
            </el-table-column>
        </el-table>
    </div>
</div>

<script>
    new Vue({
        el: "#div1",
        data() {
            return {
                usergroup_id: null,
                UserGroup: [],
                items: null
            }
        },
        async created() {
            this.UserGroup = (await this.$vx.get("ACL/all?_entry=getUserGroup")).data;


        },
        watch: {
            async usergroup_id() {
                if (!this.usergroup_id) {
                    this.items = [];
                    return;
                }

                let resp = (await this.$vx.get("ACL/all", {
                    params: {
                        _entry: "getACL",
                        usergroup_id: this.usergroup_id
                    }
                })).data;
                this.items = resp;
            }
        },
        methods: {
            async changePathValue(module, path, value, checked) {

                let resp = await this.$vx.post("ACL/all", {
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

                let resp = await this.$vx.post("ACL/all", {
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

return new class
{
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
        $usergroup = new UserGroup($vx->query["usergroup_id"]);
        $ret = [];
        foreach ($vx->getModules() as $module) {
            $r = [];
            $r["name"] = $module->name;

            $r["FC"] = ["value" => getACLValue($usergroup, $module, "FC"), "disabled" => getACLPreset($usergroup, $module, "FC")];
            $r["C"] = ["value" => getACLValue($usergroup, $module, "C"), "disabled" => getACLPreset($usergroup, $module, "C")];
            $r["R"] = ["value" => getACLValue($usergroup, $module, "R"), "disabled" => getACLPreset($usergroup, $module, "R")];
            $r["U"] = ["value" => getACLValue($usergroup, $module, "U"), "disabled" => getACLPreset($usergroup, $module, "U")];
            $r["D"] = ["value" => getACLValue($usergroup, $module, "D"), "disabled" => getACLPreset($usergroup, $module, "D")];



            $r["files"] = [];

            foreach ($module->getFiles() as $file) {
                $r["files"][] = [
                    "name" => $file,
                    "allow" => [
                        "checked" => $this->getACLPathValue($usergroup, $module, $file, "allow"),
                        "disabled" => $this->getACLPathPreset($usergroup, $module, $file, "allow")
                    ],
                    "deny" => [
                        "checked" => $this->getACLPathValue($usergroup, $module, $file, "deny"),
                        "disabled" => $this->getACLPathPreset($usergroup, $module, $file, "deny")
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
        $allow_ug = $acl["path"][$module->name . "/" . $path];

        return in_array($usergroup->name, $allow_ug);
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
        $allow_ug = $acl["path"][$module->name . "/" . $path];
        if (in_array($usergroup->name, $allow_ug)) {
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
};

function getACLValue(UserGroup $usergroup, Module $module, string $action)
{
    if ($usergroup->name == "Administrators") {
        return true;
    }
    $yml = new Parser();
    $acl = $yml->parseFile(dirname(__DIR__, 2) . "/acl.yml");
    if (in_array($usergroup->name,  $acl["action"][$action][$module->name] ?? [])) {
        return true;
    }

    $allow = ACL::Query([
        "value" => "allow",
        "module" => $module->name,
        "action" => $action,
        "usergroup_id" => $usergroup->usergroup_id,
    ])->count() > 0;

    if ($allow) {
        return $allow;
    }
}

function getACLPreset(UserGroup $usergroup, Module $module, string $action)
{
    if ($usergroup->name == "Administrators") {
        return true;
    }

    $yml = new Parser();
    $acl = $yml->parseFile(dirname(__DIR__, 2) . "/acl.yml");
    return in_array($usergroup->name,  $acl["action"][$action][$module->name]);
}
