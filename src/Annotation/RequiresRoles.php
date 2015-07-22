<?php
/**
 * This file is part of the Ray.AuthorizationModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\AuthorizationModule\Annotation;

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
