<?php

namespace General\Service\Factory;

use General\Service\PostMarkService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Postmark\PostmarkClient;
use Psr\Container\ContainerInterface;

class PostMarkServiceFactory implements FactoryInterface
{


    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new PostMarkService();
        $postmarkClient = new PostmarkClient("35fcd24c-72e2-4bbf-8a04-1b961d421450");
        $xserv->setPostmarkClient($postmarkClient);
        return $xserv;
    }
}
