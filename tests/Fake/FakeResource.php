<?php
/**
 * This file is part of the Ray.AuthorizationModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\AuthorizationModule;


use Ray\AuthorizationModule\Annotation\RequiresRoles;

class FakeResource
{
    /**
     * @RequiresRoles({"admin"})
     */
    public function createUser()
    {
        return true;
    }
}