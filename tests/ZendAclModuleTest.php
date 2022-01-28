<?php

namespace Ray\RoleModule;

use PHPUnit\Framework\TestCase;
use Ray\RoleModule\Exception\RequiredRolesException;
use Ray\Di\Injector;
use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\Role\GenericRole;

class ZendAclModuleTest extends TestCase
{
    public function testModuleAllow()
    {
        $acl = new Acl();
        $acl->addRole(new GenericRole('admin'));
        $injector = new Injector(new ZendAclModule($acl, FakeRoleAdminProvider::class), __DIR__ . '/tmp');
        /** @var $resource FakeResource */
        $resource = $injector->getInstance(FakeResource::class);
        $result = $resource->createUser();
        $this->assertTrue($result);
    }

    public function testModuleDeny()
    {
        $this->expectException(RequiredRolesException::class);
        $acl = new Acl();
        $acl->addRole(new GenericRole('admin'));
        $acl->addRole(new GenericRole('guest'));
        $injector = new Injector(new ZendAclModule($acl, FakeRoleGuestProvider::class), __DIR__ . '/tmp');
        /** @var $resource FakeResource */
        $resource = $injector->getInstance(FakeResource::class);
        $resource->createUser();
    }

    public function testModuleClassDeny()
    {
        $this->expectException(RequiredRolesException::class);
        $acl = new Acl();
        $acl->addRole(new GenericRole('admin'));
        $acl->addRole(new GenericRole('guest'));
        $injector = new Injector(new ZendAclModule($acl, FakeRoleGuestProvider::class), __DIR__ . '/tmp');
        /** @var $resource FakeClassResource */
        $resource = $injector->getInstance(FakeClassResource::class);
        $resource->createUser();
    }
}
