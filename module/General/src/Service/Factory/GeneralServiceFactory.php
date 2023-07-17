<?php

namespace General\Service\Factory;

use Doctrine\ORM\EntityManager;
use General\Entity\Settings;
use General\Service\GeneralService;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class GeneralServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new GeneralService();
        /**
         * @var EntityManager
         */
        $entityManager = $container->get(EntityManager::class);
        $authService = $container->get("authentication_service");
        $settings = $entityManager->find(Settings::class, 100);
        $ctr->setEntityManager($entityManager)->setAuth($authService)->setSettings($settings);
        return $ctr;
    }
}
