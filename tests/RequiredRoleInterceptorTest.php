<?php

namespace Ray\RoleModule;

use Doctrine\Common\Annotations\AnnotationReader;
use Ray\Aop\Arguments;
use Ray\Aop\ReflectiveMethodInvocation;
use Ray\RoleModule\Exception\RequiredRolesException;
use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Role\GenericRole;

class RequiredRoleInterceptorTest extends \PHPUnit_Framework_TestCase
{
    private function factory($obj, $method, AclInterface $acl, RoleProviderInterface $roleProvider, $args = [])
    {
        $invocation = new ReflectiveMethodInvocation(
            $obj, new \ReflectionMethod($obj, $method), new Arguments($args), [
                new RequiredRolesInterceptor(new AnnotationReader, $acl, $roleProvider)
            ]
        );
        return $invocation;
    }

    public function testNewInstance()
    {
        $acl = new Acl();
        $invocation = $this->factory(new FakeResource, 'createUser', new Acl, new FakeRoleAdminProvider);
        $this->assertInstanceOf(ReflectiveMethodInvocation::class, $invocation);
    }

    public function testMethodAllowed()
    {
        $acl = new Acl();
        $acl->addRole(new GenericRole('admin'));
        $invocation = $this->factory(new FakeResource, 'createUser', $acl, new FakeRoleAdminProvider);
        $result = $invocation->proceed();
        $this->assertTrue($result);
    }

    public function testMethodDeny()
    {
        $this->setExpectedException(RequiredRolesException::class);
        $acl = new Acl();
        $acl->addRole(new GenericRole('admin'));
        $acl->addRole(new GenericRole('guest'));
        $invocation = $this->factory(new FakeResource, 'createUser', $acl, new FakeRoleGuestProvider);
        $result = $invocation->proceed();
        $this->assertTrue($result);
    }
}
