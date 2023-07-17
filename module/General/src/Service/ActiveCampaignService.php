<?php

namespace General\Service;

use General\Service\GeneralService;
use Laminas\Http\Client;

class ActiveCampaignService
{
    /**
     * Undocumented variable
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     * Undocumente
     *
     * @var Client
     */
    private $activeInstance;

    const ACTIVE_CAMPAIGN_BASE_URI = "https://tercesjobs.api-us1.com";

    public function createContact($data)
    {
        $client = $this->activeInstance;
        $client->setUri(self::ACTIVE_CAMPAIGN_BASE_URI . "/api/3/contacts");
        $client->setMethod("POST");
        $post = [
            "contact" => [
                "email" => $data["email"],
                "firstName" => $data["firstname"] ?? "",
                "lastName" => $data["lastname"] ?? "",
                "phone" => $data["phone"],
            ]
        ];
        $client->setRawBody(json_encode($post));
        $response = $client->send();
        if ($response->isSuccess()) {
            $data = json_decode($response->getBody());
            return [
                "id" => $data->contact->id,
                "data" => json_encode($data),
            ];
        } else {
            throw new \Exception($response->getReasonPhrase());
        }
    }


    /**
     * Undocumented function
     * @var $data array | list, contact
     * @param [type] $data
     * @return void
     */
    public function updateContactList($data)
    {
        $client = $this->activeInstance;
        $client->setUri(self::ACTIVE_CAMPAIGN_BASE_URI . "/api/3/contactLists");
        $client->setMethod("POST");
        $post = [
            "contactList" => [
                "list" => $data["list"],
                "contact" => $data["contact"],
                "status" => 1,
            ]
        ];
        $client->setRawBody(json_encode($post));
        $response = $client->send();
        if ($response->isSuccess()) {
            $data = json_decode($response->getBody());
            // return [
            //     "id" => $data->contact->id,
            //     "data" => json_encode($data),
            // ];
        } else {
            throw new \Exception($response->getReasonPhrase());
        }
    }


    /**
     * Get the value of generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * Set the value of generalService
     *
     * @return  self
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;

        return $this;
    }

    /**
     * Get the value of activeInstance
     */
    public function getActiveInstance()
    {
        return $this->activeInstance;
    }

    /**
     * Set the value of activeInstance
     *
     * @return  self
     */
    public function setActiveInstance($activeInstance)
    {
        $this->activeInstance = $activeInstance;

        return $this;
    }
}
