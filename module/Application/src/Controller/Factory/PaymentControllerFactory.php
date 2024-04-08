<?php

namespace Application\Controller\Factory;

use Application\Controller\PaymentController;
use Application\Service\PaystackService;
use Application\Service\StripeService;
use Application\Service\TransactionService;
use General\Service\ActiveCampaignService;
use General\Service\GeneralService;
use General\Service\PostMarkService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class PaymentControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new PaymentController();
        $paystackService = $container->get(PaystackService::class);
        /**
         * @var GeneralService
         */
        $generalService = $container->get(GeneralService::class);
        $postmarkService = $container->get(PostMarkService::class);
        $activeCampaignService = $container->get(ActiveCampaignService::class);
        $stripeService = $container->get(StripeService::class);
        $transactionService = $container->get(TransactionService::class);


        $ctr->setPaystackService($paystackService)
            ->setPaystackConfig($paystackService->getPaystackConfig())
            ->setEntityManager($generalService->getEntityManager())->setStripeService($stripeService)
            ->setTransactionService($transactionService);
        return $ctr;
    }
}
