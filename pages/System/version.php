<?php

return new class
{
    public function get(VX $vx)
    {

        $schema = $vx->createSchema();

        $lists = $schema->addQCard()->addLists();

        $lists->item("PHP", PHP_VERSION);
        $lists->item("puxt-vx", Composer\InstalledVersions::getVersion("mathsgod/puxt-vx"));
        $lists->item("puxt", Composer\InstalledVersions::getVersion("mathsgod/puxt"));

        return $schema;
    }
};
