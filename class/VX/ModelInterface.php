<?php

namespace VX;

interface ModelInterface
{
    public function uri(?string $name = null): string;

    public function save();
    public function delete();
    public function bind($obj);
    static function Load(int $id): ?static;

    public function _id();
}
