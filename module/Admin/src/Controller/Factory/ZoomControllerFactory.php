<?php

namespace Admin\Controller\Factory;

use Admin\Controller\ZoomController;
use Application\Service\ZoomService;
use General\Service\GeneralService;
use General\Service\UploadService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ZoomControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new ZoomController();
        $uploadService = $container->get(UploadService::class);
        /**
         * @var GeneralService
         */
        $generalService = $container->get(GeneralService::class);
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setZoomService($container->get(ZoomService::class));
        return $ctr;
    }
}
