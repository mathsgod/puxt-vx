<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-23 
 */
return new class
{
    function get(VX $vx)
    {
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
