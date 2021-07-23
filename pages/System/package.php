{{table|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-23 
 */

use VX\UI\EL\Table;

return new class
{
    function get(VX $vx)
    {
        $table = new Table;
        $table->setData(iterator_to_array($this->data()));
        $table->addColumn("Name", "name")->sortable();
        $table->addColumn("Version", "version")->sortable();
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
