<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Ray\Di\Injector;
use Ray\RoleModule\Annotation\RequiresRoles;
use Ray\RoleModule\Exception\RequiredRoleException;
use Ray\RoleModule\RoleProviderInterface;
use Ray\RoleModule\ZendAclModule;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;

$loader = require dirname(dirname(__DIR__)) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);


class RoleProvider implements RoleProviderInterface
{
    public function get()
    {
        return 'guest';
    }
}

class Admin
{
    /**
     * @RequiresRoles({"login"})
     */
    public function createUser($id)
    {
        // login required
        echo "user {$id} created";
    }
}

$acl = new Acl;
$acl->addRole(new GenericRole('guest'));
$acl->addRole(new GenericRole('login'));
$admin = (new Injector(new ZendAclModule($acl, RoleProvider::class)))->getInstance(Admin::class);
/** @var $admin Admin */
try {
    $admin->createUser('ray');
} catch (RequiredRoleException $e) {
    echo "It works !" . PHP_EOL;
}
