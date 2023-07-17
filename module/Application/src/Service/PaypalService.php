<?php


namespace Application\Service;

use Laminas\Http\Client;
use Laminas\Http\Request;

class PaypalService
{


    /**
     * Undocumented variable
     *
     * @var Client
     */
    private $client;

    /**
     * Undocumented variable
     *
     * @var 
     */
    private $responseBody;

    /**
     * Undocumented variable
     *
     * @var array
     */
    private $paypalConfig;


    public function createOrder($data)
    {
        $responseBody = $this->responseBody;
        // var_dump($this->paypalConfig);
        $client = new Client();
        $client->setUri($this->paypalConfig["create_order_url"]);
        $client->setMethod(Request::METHOD_POST);
        $client->setHeaders([
            "Authorization" => "Bearer {$responseBody->access_token}",
            // "PayPal-Request-Id" => "",
            "Content-Type" => "application/json"
        ]);

        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => $data["tx_ref"],
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $data["price"]
                    ]
                ]
            ],
            // "payment_source" => [
            //     "paypal" => [
            //         "experience_context" => [
            //             "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
            //             "payment_method_selected" => "PAYPAL",
            //             "brand_name" => "EXAMPLE INC",
            //             "locale" => "en-US",
            //             "landing_page" => "LOGIN",
            //             "shipping_preference" => "SET_PROVIDED_ADDRESS",
            //             "user_action" => "PAY_NOW",
            //             "return_url" => "https://example.com/returnUrl",
            //             "cancel_url" => "https://example.com/cancelUrl"
            //         ]
            //     ]
            // ]
        ];
        $client->setRawBody(json_encode($data));
        $res = $client->send();
        if ($res->isSuccess()) {
            // var_dump("Got Here");
            return $res->getBody();
        } else {
            throw new \Exception($res->getReasonPhrase());
        }
    }


    public function capturePayment($id)
    {
        $responseBody = $this->responseBody;
        $client = new Client();
        $client->setUri($this->paypalConfig["base_url"] . "/v2/checkout/orders/{$id}/capture");

        $client->setMethod(Request::METHOD_POST);
        $client->setHeaders([
            "Authorization" => "Bearer {$responseBody->access_token}",
            // "PayPal-Request-Id" => "",
            "Content-Type" => "application/json"
        ]);

        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => $data["tx_ref"],
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $data["price"]
                    ]
                ]
            ],
            // "payment_source" => [
            //     "paypal" => [
            //         "experience_context" => [
            //             "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
            //             "payment_method_selected" => "PAYPAL",
            //             "brand_name" => "EXAMPLE INC",
            //             "locale" => "en-US",
            //             "landing_page" => "LOGIN",
            //             "shipping_preference" => "SET_PROVIDED_ADDRESS",
            //             "user_action" => "PAY_NOW",
            //             "return_url" => "https://example.com/returnUrl",
            //             "cancel_url" => "https://example.com/cancelUrl"
            //         ]
            //     ]
            // ]
        ];
        $client->setRawBody(json_encode($data));
        $res = $client->send();
        if ($res->isSuccess()) {
            // var_dump("Got Here");
            return $res->getBody();
        } else {
            throw new \Exception($res->getReasonPhrase());
        }
    }

    /**
     * Get undocumented variable
     *
     * @return  Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set undocumented variable
     *
     * @param  Client  $client  Undocumented variable
     *
     * @return  self
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Set undocumented variable
     *
     * 
     *
     * @return  self
     */
    public function setResponseBody($responseBody)
    {
        $this->responseBody = $responseBody;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  array
     */
    public function getPaypalConfig()
    {
        return $this->paypalConfig;
    }

    /**
     * Set undocumented variable
     *
     * @param  array  $paypalConfig  Undocumented variable
     *
     * @return  self
     */
    public function setPaypalConfig(array $paypalConfig)
    {
        $this->paypalConfig = $paypalConfig;

        return $this;
    }
}
