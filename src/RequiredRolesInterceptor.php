<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\RoleModule;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\RoleModule\Annotation\RequiresRoles;
use Ray\RoleModule\Exception\RequiredRolesException;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Resource\GenericResource;

class RequiredRolesInterceptor implements MethodInterceptor
{
    private AclInterface $acl;

    private RoleProviderInterface $roleProvider;

    public function __construct(AclInterface $acl, RoleProviderInterface $roleProvider)
    {
        $this->acl = $acl;
        $this->roleProvider = $roleProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $attrs = $invocation->getMethod()->getAttributes(RequiresRoles::class);
        if (! $attrs) {
            $class = new \ReflectionClass($invocation->getThis());
            $attrs = $class->getAttributes(RequiresRoles::class);
        }
        if (! $attrs) {
            return $invocation->proceed();
        }

        $annotation = $attrs[0]->newInstance();
        $target = get_class($invocation->getThis());
        $this->acl->addResource(new GenericResource($target));
        foreach ($annotation->value as $role) {
            $this->acl->allow($role, $target);
        }
        $role = $this->roleProvider->get();
        $isAllowed = $this->acl->isAllowed($role, $target);
        if ($isAllowed) {
            return $invocation->proceed();
        }
        $msg = sprintf("%s for %s", $role, $target);
        $e = new RequiredRolesException($msg);
        $e->setMethodInvocation($invocation);

        throw $e;
    }
}
