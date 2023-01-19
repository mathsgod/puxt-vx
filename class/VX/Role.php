<?php

namespace VX;

class Role extends Model
{
    /**
     * @return Role[]
     */
    function getChildren(): array
    {
        return Role::Query(["parent" => $this->name])->toArray();
    }

    public function delete()
    {
        UserRole::Query(["role" => $this->name])->delete();
        parent::delete();
    }
}
