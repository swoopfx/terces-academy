<?php

namespace Internship\Controller\Factory;

use General\Service\GeneralService;
use Internship\Controller\ProjectController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ProjectsControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new ProjectController();
        /**
         * @var GeneralService
         */
        $generalService = $container->get(GeneralService::class);
        $ctr->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}
