<?php

namespace Application\Service\Factory;

use Application\Service\ZoomService;
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
        $activeZoomConfig = $zoomConfig[$config["active_env"]];
        $client = new Client();
        $base64 = base64_encode($activeZoomConfig["client_id"] . ":" . $activeZoomConfig["client_secret"]);
        $client->setUri($zoomConfig["base_url"] . "/oauth/token");
        $client->setHeaders([
            "Authorization" => "Basic " . $base64,
            "Content-Type" => "application/x-www-form-urlencoded",
        ]);
        $body = [
            "grant_type" => "account_credentials",
            "account_id" => $zoomConfig["account_id"]
        ];
        $response = $client->send();
        if ($response->isSuccess()) {
            $xserv->setZoomTokenRes(json_decode($response->getBody(), true));
        } else {
            throw new \Exception("Could not retrieve Zoom Token");
        }
        $xserv->setConfig($config)->setZoomConfig($zoomConfig);

        return $xserv;
    }
}
