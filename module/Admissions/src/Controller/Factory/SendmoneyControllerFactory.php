<?php

namespace Admissions\Controller\Factory;

use Admissions\Controller\SendmoneyController;
use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class SendmoneyControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new SendmoneyController();
        $generalService = $container->get(GeneralService::class);
        $config = $container->get("config");
        $ctr->setConfig($config)->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}
