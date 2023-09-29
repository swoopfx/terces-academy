<?php

namespace Application\Service\Factory;

use Application\Service\StripeService;
use General\Service\GeneralService;
use General\Service\PostMarkService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Stripe\StripeClient;

class StripeServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new StripeService();
        $config = $container->get("config");
        $generalService = $container->get(GeneralService::class);
        $postmarkService = $container->get(PostMarkService::class);
        $stripeConfig = $config["stripe"];
        $stripeClient = new StripeClient($stripeConfig["secret_key"]);
        $xserv->setStripeClient($stripeClient)->setGeneralService($generalService)
            ->setPostmarkService($postmarkService);
        return $xserv;
    }
}
