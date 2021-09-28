{{table|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-23 
 */

return new class
{
    function get(VX $vx)
    {

        $table = $vx->ui->createT($this->data());
        $table->add("Name", "name")->sortable();
        $table->add("Version", "version")->sortable();
        $this->table = $table;
    }

    function data()
    {

        foreach (Composer\InstalledVersions::getInstalledPackages() as $package) {
            yield [
                "name" => $package,
                "version" => Composer\InstalledVersions::getVersion($package)
            ];
        }
    }
};
