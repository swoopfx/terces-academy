<?php

namespace Authentication\Controller\Factory;

use Authentication\Controller\ZoomController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ZoomControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new ZoomController();
        return $ctr;
    }
}
