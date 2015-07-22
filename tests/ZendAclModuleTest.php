<?php

namespace Ray\RoleModule;

use Ray\RoleModule\Exception\RequiredRoleException;
use Ray\Di\Injector;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;

class ZendAclModuleTest extends \PHPUnit_Framework_TestCase
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
        $this->setExpectedException(RequiredRoleException::class);
        $acl = new Acl();
        $acl->addRole(new GenericRole('admin'));
        $acl->addRole(new GenericRole('guest'));
        $injector = new Injector(new ZendAclModule($acl, FakeRoleGuestProvider::class), __DIR__ . '/tmp');
        /** @var $resource FakeResource */
        $resource = $injector->getInstance(FakeResource::class);
        $result = $resource->createUser();
    }
}
