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
        $config = $container->get("config");
        $client = new Client();
        $client->setHeaders([
            "Api-Token" => $config["active_campaign"]
        ]);
        // $client->setUri("https://tercesjobs.api-us1.com");
        $xserv->setActiveInstance($client)->setGeneralService($generalService);
        return $xserv;
    }
}
