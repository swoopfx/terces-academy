<?php

namespace Admin\Controller\Factory;

use Admin\Controller\ZoomController;
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
        $ctr->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}
