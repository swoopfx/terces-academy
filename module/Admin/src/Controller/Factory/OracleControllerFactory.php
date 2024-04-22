<?php

namespace Admin\Controller\Factory;

use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class OracleControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new $requestedName();
        $generalService = $container->get(GeneralService::class);
        $ctr->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}
