<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\RoleModule\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
final class RequiresRoles
{
    /**
     * @var array
     */
    public $value;
}
