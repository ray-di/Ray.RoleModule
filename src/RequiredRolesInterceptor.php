<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\RoleModule;

use Doctrine\Common\Annotations\Reader;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\RoleModule\Annotation\RequiresRoles;
use Ray\RoleModule\Exception\RequiredRolesException;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Resource\GenericResource;

class RequiredRolesInterceptor implements MethodInterceptor
{
    private $reader;

    /**
     * @var AclInterface
     */
    private $acl;

    private $roleProvider;

    public function __construct(Reader $reader, AclInterface $acl, RoleProviderInterface $roleProvider)
    {
        $this->reader = $reader;
        $this->acl = $acl;
        $this->roleProvider = $roleProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        /** @var $annotation RequiresRoles */
        $annotation = $this->reader->getMethodAnnotation($invocation->getMethod(), RequiresRoles::class);
        if (! $annotation) {
            $class = new \ReflectionClass($invocation->getThis());
            $annotation = $this->reader->getClassAnnotation($class, RequiresRoles::class);
        }
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
