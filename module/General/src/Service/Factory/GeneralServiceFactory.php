<?php

namespace General\Service\Factory;

use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class GeneralServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new GeneralService();
        $entityManager = $container->get(EntityManager::class);
        $authService = $container->get("authentication_service");
        $ctr->setEntityManager($entityManager)->setAuth($authService);
        return $ctr;
    }
}
