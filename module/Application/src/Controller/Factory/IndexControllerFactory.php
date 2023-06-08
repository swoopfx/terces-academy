<?php

namespace Application\Controller\Factory;

use Application\Controller\IndexController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new IndexController();
        $generalService = $container->get("general_service");
        $ctr->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}
