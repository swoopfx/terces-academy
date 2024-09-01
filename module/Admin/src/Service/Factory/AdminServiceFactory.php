<?php

namespace Admin\Service\Factory;

use General\Service\GeneralService;
use General\Service\PostMarkService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AdminServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new $requestedName();
        /**
         * @var GeneralService
         */
        $generalService = $container->get(GeneralService::class);
        $xserv->setEntityManager($generalService->getEntityManager())
            ->setPostmarkService($container->get(PostMarkService::class));
        return $xserv;
    }
}
