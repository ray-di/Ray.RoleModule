# Ray.AuthorizationModule


## Installation

### Composer install

    $ composer require ray/authorization-module
 
### Module install

```php
use Ray\AuthorizationModule\AuthorizationModule;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        // @see http://framework.zend.com/manual/current/en/modules/zend.permissions.acl.intro.html
        $acl = new Acl();
        $roleGuest = new Role('guest');
        $acl->addRole($roleGuest);
        $acl->addRole(new Role('staff'), $roleGuest);
        $acl->addRole(new Role('editor'), 'staff');
        $acl->addRole(new Role('administrator'));
        $this->install(new AuthorizationModule($acl));
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
     * @RequiresRoles(value={"admin","editor"}, logical=OR)
     */
    public function createUser($id)
    {
```

 
### Requirements

 * PHP 5.4+
 * hhvm
