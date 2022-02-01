<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\RoleModule;


use Ray\RoleModule\Annotation\RequiresRoles;

/**
 * @RequiresRoles({"admin"})
 */
#[RequiresRoles(value: ['admin'])]
class FakeClassResource
{
    public function createUser()
    {
        return true;
    }
}
