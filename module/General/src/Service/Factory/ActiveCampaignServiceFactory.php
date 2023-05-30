<?php

namespace General\Service\Factory;

use General\Service\ActiveCampaignService;
use General\Service\GeneralService;
use Laminas\Http\Client;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ActiveCampaignServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new ActiveCampaignService();
        $generalService = $container->get(GeneralService::class);
        $header["Api-Token"] = "d91e86140f20426178a8b1d48263e2f09a64104a2d79501f01b788a7e8ccfba74ab38cea";
        $client = new Client();
        $client->setHeaders($header);
        $xserv->setActiveInstance($client)->setGeneralService($generalService);
        return $xserv;
    }
}
