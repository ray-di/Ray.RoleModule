# Ray.AuthorizationModule

> **WORK IN PROGRESS.**

## Installation

### Composer install

    $ composer require ray/authorization-module
 
### Module install

You need to provide `RoleProvider`.

```php
class AppRoleProvider implements RoleProviderInterface
{
    public function get()
    {
        return 'admin';
    }
}
```

Install module with `RoleProvider`.

```php
use Ray\AuthorizationModule\AuthorizationModule;
use Ray\Di\AbstractModule;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Acl;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        // @see http://framework.zend.com/manual/current/en/modules/zend.permissions.acl.intro.html
        $acl = new Acl();
        $roleGuest = new GenericRole('guest');
        $acl->addRole($roleGuest);
        $acl->addRole(new GenericRole('staff'), $roleGuest);
        $acl->addRole(new GenericRole('editor'), 'staff');
        $acl->addRole(new GenericRole('administrator'));
        $this->install(new AuthorizationModule($acl, AppRoleProvider::class));
    }
}
```

### Usage

Simple usage:

```php
class Foo
{
    /**
     * @RequiresRoles({"admin"})
     */
    public function createUser($id)
    {
```

```php
class Foo
{
    /**
     * @RequiresRoles({"admin","editor"})
     */
    public function createUser($id)
    {
```

 
### Requirements

 * PHP 5.4+
 * hhvm
