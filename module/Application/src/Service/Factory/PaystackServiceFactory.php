<?php

namespace Application\Service\Factory;

use Application\Service\PaystackService;
use General\Service\GeneralService;
use General\Service\PostMarkService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class PaystackServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new PaystackService();
        $config = $container->get("config");
        $baseEndpoint = "https://api.paystack.co";
        $paystackConfig = (getenv('APPLICATION_ENV') == "development" ? $config["paystack"]["dev"] : $config['paystack']['live']);
        $generalService = $container->get(GeneralService::class);
        $postMarkService = $container->get(PostMarkService::class);
        $em = $generalService->getEntityManager();
        $xserv
            ->setGeneralService($generalService)
            ->setEntityManager($em)
            ->setBaseEndpoint($baseEndpoint)
            ->setPostmarkService($postMarkService)
            ->setPublicKey($paystackConfig["public_key"])
            ->setSecretKey($paystackConfig["secret_key"]);

        return $xserv;
    }
}
