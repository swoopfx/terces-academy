<?php

namespace Application\Controller\Factory;

use Application\Controller\AppController;
use General\Service\ActiveCampaignService;
use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AppControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new AppController();
        $generalService = $container->get(GeneralService::class);
        $activeCampaignService = $container->get(ActiveCampaignService::class);
        $ctr->setEntityManager($generalService->getEntityManager())->setActiveCampaignService($activeCampaignService);
        return $ctr;
    }
}
