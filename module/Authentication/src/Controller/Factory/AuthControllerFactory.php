<?php

namespace Authentication\Controller\Factory;

use Authentication\Controller\AuthController;
use Exception;
use General\Service\ActiveCampaignService;
use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AuthControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new AuthController();
        if (!$container->has(ActiveCampaignService::class)) {
            throw new \Exception("Auth Controller cannot retrive Active Campaign Service");
        }
        $generalService = $container->get(GeneralService::class);
        // var_dump($generalService->getAuth());
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setAuthService($generalService->getAuth())
            ->setActiveCampaignService($container->get(ActiveCampaignService::class));
        return $ctr;
    }
}
