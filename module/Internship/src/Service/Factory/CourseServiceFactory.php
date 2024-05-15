<?php

namespace Internship\Service\Factory;

use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class CourseServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new $requestedName();
        /**
         * @var GeneralService
         */
        $generalService  = $container->get(GeneralService::class);
        $xserv->setEntityManager($generalService->getEntityManager());
        return $xserv;
    }
}
