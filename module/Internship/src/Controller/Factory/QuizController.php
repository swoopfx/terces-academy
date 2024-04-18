<?php
namespace Internship\Controller\Factory;

use General\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class QuizController implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new $requestedName();
        /**
         * @var GeneralService
         */
        $generalService  = $container->get(GeneralService::class);
        return $ctr;
    }
}