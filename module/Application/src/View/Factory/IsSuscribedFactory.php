<?php

namespace Application\View\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Entity\ActiveUserProgram;
use Application\View\IsSubscribed;
use General\Service\GeneralService;
use Psr\Container\ContainerInterface;

class IsSuscribedFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $view = new IsSubscribed();
        /**
         * @var GeneralService
         */
        $generalService = $container->get(GeneralService::class);
        $auth = $container->get("authentication_service");
        // var_dump($auth);
        $em = $generalService->getEntityManager();

        $view->setEm($em)->setAuth($auth);
        return $view;
    }
}
