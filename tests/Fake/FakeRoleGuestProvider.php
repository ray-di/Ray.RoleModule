<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\RoleModule;

class FakeRoleGuestProvider implements RoleProviderInterface
{
    public function get()
    {
        return 'guest';
    }
}