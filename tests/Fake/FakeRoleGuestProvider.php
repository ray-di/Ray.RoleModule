<?php
/**
 * This file is part of the Ray.AuthorizationModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\AuthorizationModule;

class FakeRoleGuestProvider implements RoleProviderInterface
{
    public function get()
    {
        return 'guest';
    }
}