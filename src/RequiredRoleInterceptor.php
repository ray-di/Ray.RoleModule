<?php
/**
 * This file is part of the Ray.AuthorizationModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\AuthorizationModule;

use Doctrine\Common\Annotations\Reader;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\AuthorizationModule\Annotation\RequiresRoles;
use Ray\AuthorizationModule\Exception\RequiredRoleException;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\AclInterface;
use Zend\Permissions\Acl\Resource\GenericResource;

class RequiredRoleInterceptor implements MethodInterceptor
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
        throw new RequiredRoleException($invocation);
    }
}
