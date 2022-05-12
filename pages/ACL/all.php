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
            $d[] = $r["all"]["value"] ? "✓" : "";
            $d[] = $r["create"]["value"] ? "✓" : "";
            $d[] = $r["read"]["value"] ? "✓" : "";
            $d[] = $r["update"]["value"] ? "✓" : "";
            $d[] = $r["delete"]["value"] ? "✓" : "";

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
                $d[] = $f["allow"]["checked"] ? "✓" : "";
                $d[] = $f["deny"]["checked"] ? "✓" : "";

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
