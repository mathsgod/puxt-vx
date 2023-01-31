<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-23 
 */

return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();
        $table = $schema->addElTable();
        $table->data(iterator_to_array($this->data()));
        $table->addColumn()->label("Name")->prop("name")->sortable();
        $table->addColumn()->label("Version")->prop("version")->sortable();

        return $schema;
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
