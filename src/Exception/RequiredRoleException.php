<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\RoleModule\Exception;

use Ray\Aop\MethodInvocation;

class RequiredRoleException extends RuntimeException
{
    public $invocation;

    public function __construct(MethodInvocation $invocation)
    {
        $this->invocation = $invocation;
    }
}
