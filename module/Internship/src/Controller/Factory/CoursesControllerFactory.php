<?php

namespace Internship\Controller\Factory;

use General\Service\GeneralService;
use Internship\Service\CourseService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class CoursesControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new $requestedName();
        /**
         * @var GeneralService
         */
        $generalService = $container->get(GeneralService::class);
        $ctr->setEntityManager($generalService->getEntityManager())->setCourseService($container->get(CourseService::class));
        return $ctr;
    }
}
