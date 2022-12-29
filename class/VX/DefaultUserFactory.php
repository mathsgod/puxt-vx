<?php

namespace VX;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class DefaultUserFactory implements FactoryInterface
{
    function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return User::Get(2);//default user is guest
    }
}
