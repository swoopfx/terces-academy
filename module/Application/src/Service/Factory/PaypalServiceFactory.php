<?php

namespace Application\Service\Factory;

use Application\Service\PaypalService;
use Laminas\Http\Client;
use Laminas\Http\Client\Adapter\Curl;
use Laminas\Http\Request;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class PaypalServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new PaypalService();
        $config = $container->get("config");
        $paypalConfig = $config["paypal"];
        // var_dump($paypalConfig);
        $decodedBodey = '';
        $client = '';
        try {


            $client = new Client();


            $client->setAuth($paypalConfig["client_id"], $paypalConfig["secret_key"], Client::AUTH_BASIC);
            $client->setUri($paypalConfig["auth_url"]);
            $client->setMethod(Request::METHOD_POST);
            $client->setHeaders(array(
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
            ));
            $post = ["grant_type" => "client_credentials"];
            // $client->setRawBody(json_encode($post));
            $client->setParameterPost($post);
            $res = $client->send();
            if ($res->isSuccess()) {
                $decodedBodey = json_decode($res->getBody());
            } else {
                return $res->getReasonPhrase();
            }
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
            // var_dump($th->getMessage());
        }
        $xserv->setClient($client)->setResponseBody($decodedBodey)->setPaypalConfig($paypalConfig);
        return $xserv;
    }
}
