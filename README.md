# Ray.RoleModule

## Installation

### Composer install

    $ composer require ray/role-module
 
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
use Ray\RoleModule\ZendAclModule;
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
        $this->install(new ZendAclModule($acl, AppRoleProvider::class));
    }
}
```

### Usage

Simple usage:

```php
use Ray\RoleModule\Annotation\RequiresRoles;

/**
 * @RequiresRoles({"admin"})
 */
class Foo
{
    public function createUser($id)
    {
```

You can annotated individual method too, It has priority over class annotation.
```php
class Foo
{
    /**
     * @RequiresRoles({"admin", "editor"})
     */
    public function createUser($id)
    {
```

### Demo
```php
$ php docs/demo/run.php
// It works!
```

### Requirements

 * PHP 5.4+
 * hhvm
