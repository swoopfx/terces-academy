<?php


namespace Application\Service\Factory;

use Application\Service\PaypalService;
use Application\Service\TransactionService;
use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class TransactionServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new TransactionService();
        $generalService = $container->get(GeneralService::class);
        $paypalService = $container->get(PaypalService::class);
        $xserv->setGeneralService($generalService)->setPaypalService($paypalService);
        return $xserv;
    }
}
