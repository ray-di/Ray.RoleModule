# Upgrade Guide

## 2.0.0

### Breaking changes

#### PHP 7.x support dropped

PHP 7.3 and 7.4 are no longer supported. The minimum required version is now PHP 8.0.

```diff
 "require": {
-    "php": "^7.3 || ^8.0"
+    "php": "^8.0"
 }
```

#### Doctrine annotations (`@RequiresRoles`) removed

`doctrine/annotations` has been dropped. Docblock annotations are no longer read — the interceptor uses native PHP 8 attributes only.

Replace every docblock `@RequiresRoles` with the PHP 8 attribute form `#[RequiresRoles([...])]`.

Before:

```php
use Ray\RoleModule\Annotation\RequiresRoles;

class Admin
{
    /**
     * @RequiresRoles({"admin"})
     */
    public function createUser(string $id): void
    {
    }
}
```

After:

```php
use Ray\RoleModule\Annotation\RequiresRoles;

class Admin
{
    #[RequiresRoles(['admin'])]
    public function createUser(string $id): void
    {
    }
}
```

Class-level annotations migrate the same way. If a class or method has no `#[RequiresRoles]` attribute, the interceptor now proceeds without ACL enforcement (previously it would have relied on the docblock).

#### `koriym/attributes` dependency removed

`ZendAclModule` no longer binds `Doctrine\Common\Annotations\Reader`, `AnnotationReader`, `AttributeReader`, or `DualReader`. If your application was depending on those bindings being provided transitively by `ZendAclModule`, you will need to install `koriym/attributes` (or `doctrine/annotations`) directly and bind them yourself.
