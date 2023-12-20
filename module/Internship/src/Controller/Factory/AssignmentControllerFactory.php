<?php
namespace Internship\Controller\Factory;

use General\Service\GeneralService;
use Internship\Controller\AssignmentController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AssignmentControllerFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new AssignmentController();
        $generalService = $container->get(GeneralService::class);
        return $ctr;
    }
}