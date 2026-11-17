<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\RoleModule\Annotation;

use Attribute;

/**
 * Lets only the listed roles call the method, or every method of the class
 * Other roles pass when the injected ACL already allows them on every resource or on the class
 *
 * @see \Ray\RoleModule\RequiredRolesInterceptor
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
final class RequiresRoles
{
    /** @param list<string> $value Roles allowed to call */
    public function __construct(public array $value)
    {
    }
}
