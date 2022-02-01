<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\RoleModule\Annotation;

use Attribute;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
final class RequiresRoles
{
    /**
     * @var array
     */
    public $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }
}
