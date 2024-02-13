<?php

namespace Application\Controller\Factory;

use Application\Controller\AdminProcessController;
use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AdminProcessControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new AdminProcessController();
        /**
         * @var GeneralService
         */
        $generalService = $container->get(GeneralService::class);
        $ctr->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}
