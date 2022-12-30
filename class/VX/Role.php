<?php

namespace VX;

use A;

class Role extends Model
{
    /**
     * @return Role[]
     */
    function getChildren():array
    {
        return Role::Query(["parent_id" => $this->role_id])->toArray();
    }
}
