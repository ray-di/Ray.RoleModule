<?php

declare(strict_types=1);

namespace Ray\Demo;

use Ray\RoleModule\Annotation\RequiresRoles;

class Admin
{
    /**
     * @RequiresRoles({"login"})
     */
    public function createUser(string $id): void
    {
        // login required
        echo "user {$id} created";
    }
}
