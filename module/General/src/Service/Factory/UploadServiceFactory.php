<?php

namespace General\Service\Factory;

use General\Service\UploadService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use General\Service\GeneralService;

class UploadServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new UploadService();
        /**
         * @var GeneralService
         */
        $generalService = $container->get(GeneralService::class);
        /**
         * @var Settings
         */
        $config = $container->get("config");
        $credentials = new Credentials($config["aws"]["access_key"], $config["aws"]["secret_key"]);

        $s3 = new S3Client([
            'version'     => 'latest',
            'region'      => 'us-east-1',
            'credentials' => $credentials
        ]);

        $xserv->setS3Instance($s3)->setEntityManager($generalService->getEntityManager());
        return $xserv;
        return $xserv;
    }
}
