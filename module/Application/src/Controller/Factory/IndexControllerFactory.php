<?php

namespace Application\Controller\Factory;

use Application\Controller\IndexController;
use General\Service\GeneralService;
use General\Service\PostMarkService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new IndexController();
        $generalService = $container->get(GeneralService::class);
        $config = $container->get("config");
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setConfig($config)
            ->setPostmarkService($container->get(PostMarkService::class));
        return $ctr;
    }
}
