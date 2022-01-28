<?php

namespace Ray\Demo;

use Composer\Autoload\ClassLoader;
use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\Role\GenericRole;
use Ray\Di\Injector;
use Ray\RoleModule\Exception\RequiredRolesException;
use Ray\RoleModule\Exception\RuntimeException;
use Ray\RoleModule\RoleProviderInterface;
use Ray\RoleModule\ZendAclModule;
use Ray\RoleModule\ARoleProviderInterface;
use function interface_exists;

$loader = require dirname(__DIR__, 2) . '/vendor/autoload.php';
assert($loader instanceof ClassLoader);
$loader->addPsr4('Ray\\Demo\\', __DIR__ . '/src');

$acl = new Acl();
$acl->addRole(new GenericRole('guest'));
$acl->addRole(new GenericRole('login'));
$admin = (new Injector(new ZendAclModule($acl, RoleProvider::class)))->getInstance(Admin::class);
assert($admin instanceof Admin);
try {
    $admin->createUser('ray');
} catch (RequiredRolesException $e) {
    echo "It works !" . PHP_EOL;
}
