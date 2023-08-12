<?php

namespace Application\Controller\Factory;

use Application\Controller\AdminController;
use General\Service\GeneralService;
use General\Service\UploadService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class  AdminControllerFactory implements FactoryInterface
{


    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new AdminController();
        $generalService = $container->get(GeneralService::class);
        $uploadService = $container->get(UploadService::class);
        $ctr->setGeneralService($generalService)
            ->setEntityManager($generalService->getEntityManager())
            ->setUploadService($uploadService);
        return $ctr;
    }
}
