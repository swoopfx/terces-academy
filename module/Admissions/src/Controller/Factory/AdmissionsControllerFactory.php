<?php

namespace Admissions\Controller\Factory;

use Admissions\Controller\AdmissionsController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AdmissionsControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr  = new AdmissionsController();
        return $ctr; 
    }
}
