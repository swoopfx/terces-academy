<?php

namespace Authentication\Controller\Factory;

use Authentication\Controller\AuthController;
use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AuthControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new AuthController();
        $generalService = $container->get(GeneralService::class);
        $ctr->setEntityManager($generalService->getEntityManager())->setAuthService($generalService->getAuth());
        return $ctr;
    }
}
