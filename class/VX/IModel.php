<?php

namespace VX;

interface IModel
{
    public function canReadBy(User $user): bool;
    public function canDeleteBy(User $user): bool;
    public function canUpdateBy(User $user): bool;

    public function uri(string $name): string;

    public function save();
    public function delete();
    public function bind($obj);
    static function Load(int $id): static;
}
