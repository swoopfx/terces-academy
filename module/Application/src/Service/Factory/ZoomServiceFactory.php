<?php

namespace Application\Service\Factory;

use Application\Service\ZoomService;
use General\Service\GeneralService;
use General\Service\PostMarkService;
use Laminas\Http\Client;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ZoomServiceFactory  implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new ZoomService();
        $config = $container->get("config");
        $zoomConfig = $config["zoom"];
        // $activeZoomConfig = $zoomConfig[$config["active_env"]];
        $activeZoomConfig = $config["zoom"][$config["active_env"]];
        $client = new Client();
        $base64 = base64_encode($activeZoomConfig["client_id"] . ":" . $activeZoomConfig["client_secret"]);
        $client->setUri("https://zoom.us/oauth/token");
        $client->setMethod("POST");
        $client->setHeaders([
            "Authorization" => "Basic " . $base64,
            "Content-Type" => "application/x-www-form-urlencoded",
        ]);
        $body = [
            "grant_type" => "account_credentials",
            "account_id" => $activeZoomConfig["account_id"]
        ];

        // $client->setRawBody(json_encode($body));
        $client->setParameterPost($body);
        $response = $client->send();
        // var_dump()
        if ($response->isSuccess()) {
            //    var_dump(json_decode($response->getBody(), true));
            /**
             * @var GeneralService
             */
            $generalService = $container->get(GeneralService::class);
            $xserv->setEntityManager($generalService->getEntityManager());
            $xserv->setZoomTokenRes(json_decode($response->getBody(), true))
                ->setZoomConfig($zoomConfig)
                ->setPostmarkService($container->get(PostMarkService::class));
        } else {
            // printf($response);
            // throw new \Exception($response->getReasonPhrase());
            // throw new \Exception($response->getStatusCode());
            echo $response->getStatusCode();
        }
        // $xserv->setConfig($config)->setZoomConfig($zoomConfig);

        return $xserv;
    }
}
