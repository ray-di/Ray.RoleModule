<?php
/**
 * This file is part of the Ray.RoleModule
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\RoleModule;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Ray\RoleModule\Annotation\RequiresRoles;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Zend\Permissions\Acl\AclInterface;

class ZendAclModule extends AbstractModule
{
    /**
     * @var AclInterface
     */
    private $acl;

    /**
     * @var string
     */
    private $roleProvider;

    /**
     * @param AclInterface $acl
     * @param string       $roleProviderClass
     */
    public function __construct(AclInterface $acl, $roleProviderClass)
    {
        $this->acl = $acl;
        $this->roleProvider = $roleProviderClass;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(Reader::class)->to(AnnotationReader::class);
        $this->bind(AclInterface::class)->toInstance($this->acl);
        $this->bind(RoleProviderInterface::class)->to($this->roleProvider)->in(Scope::SINGLETON);
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(RequiresRoles::class),
            [RequiredRoleInterceptor::class]
        );
    }
}
