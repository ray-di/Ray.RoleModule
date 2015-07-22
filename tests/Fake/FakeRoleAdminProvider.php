<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\RoleModule;

class FakeRoleAdminProvider implements RoleProviderInterface
{
    public function get()
    {
        return 'admin';
    }
}
