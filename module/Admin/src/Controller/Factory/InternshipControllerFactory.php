<?php

namespace Admin\Controller\Factory;

use Admin\Controller\InternshipController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class InternshipControllerFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new InternshipController();
        return $ctr;
    }
}