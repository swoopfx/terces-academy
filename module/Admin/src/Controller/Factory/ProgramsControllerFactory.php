<?php

namespace Admin\Controller\Factory;

use Admin\Controller\ProgramsController;
use Application\Service\ZoomService;
use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ProgramsControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new ProgramsController();
        /**
         * @var GeneralService
         */
        $generalService = $container->get(GeneralService::class);
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setZoomService($container->get(ZoomService::class));
        return $ctr;
    }
}
