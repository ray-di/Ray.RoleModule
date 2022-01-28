<?php

declare(strict_types=1);

namespace Ray\Demo;

use Ray\RoleModule\RoleProviderInterface;

final class RoleProvider implements RoleProviderInterface
{
    public function get(): string
    {
        return 'guest';
    }
}
