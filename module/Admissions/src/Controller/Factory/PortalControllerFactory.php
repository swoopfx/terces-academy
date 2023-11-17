<?php
namespace Admissions\Controller\Factory;

use Admissions\Controller\PortalController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class PortalControllerFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new PortalController();
        return $ctr;
    }
}