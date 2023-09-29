<?php

namespace Application\Controller\Factory;

use Application\Controller\AppController;
use Application\Service\PaystackService;
use Application\Service\StripeService;
use Application\Service\TransactionService;
use General\Service\ActiveCampaignService;
use General\Service\GeneralService;
use General\Service\PostMarkService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AppControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new AppController();
        // $config = $container->get("config");
        /**
         * @var PaystackService
         */
        $paystackService = $container->get(PaystackService::class);
        $generalService = $container->get(GeneralService::class);
        $postmarkService = $container->get(PostMarkService::class);
        $activeCampaignService = $container->get(ActiveCampaignService::class);
        $transactionService = $container->get(TransactionService::class);
        $stripeService = $container->get(StripeService::class);
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setTransactionService($transactionService)
            ->setStripeService($stripeService)
            ->setPaystackConfig($paystackService->getPaystackConfig())
            ->setPaystackService($paystackService)
            ->setPostmarkService($postmarkService)
            ->setActiveCampaignService($activeCampaignService);
        return $ctr;
    }
}
