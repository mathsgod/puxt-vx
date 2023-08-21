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

        $list = $schema->addQCard()->addQList();
        foreach (iterator_to_array($this->data()) as $data) {
            $list->item($data["name"], $data["version"]);
        }

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
