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
        $config = $container->get("config");
        $postmark_token = $config["postmark_token"];
        $xserv = new PostMarkService();

        $postmarkClient = new PostmarkClient($postmark_token);
        $xserv->setPostmarkClient($postmarkClient);
        return $xserv;
    }
}
