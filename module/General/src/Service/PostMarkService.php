<?php

namespace General\Service;

use Postmark\PostmarkClient;

class PostMarkService
{


    /**
     * Undocumented variable
     *
     * @var PostmarkClient
     */
    private $postmarkClient;


    public function sendConfirmEmail($data)
    {


        // Send an email:
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            $data["to"],
            32356487,
            [

                "action_url" => $data["link"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,
                "name_value" => $data["name"],

            ]
        );
    }


    public function acquisitionSuccessEmail($data)
    {
        // Send an email:
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            $data["to"],
            32810913,
            [

                "product_name" => $data["product_name"],
                "name" => $data["customer_name"],

                "receipt_id" => $data["tx_ref"],
                "date" => $data["date"],
                "receipt_details" => [
                    [
                        "description" => "Being payment for " . $data["product_name"],
                        "amount" => $data["amount"]
                    ]
                ],
                "total" => $data["amount"],

                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,

            ]
        );
    }

    public function initiatedInteracPaymentForAdmin($data)
    {
        // Send an email:
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            $data["to"],
            33260477,
            [

                "sender_name" => $data["sender_name"],
                "admin" => "Admin",


                "amount" => $data["amount"],

                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,

            ]
        );
    }

    public function initiatedInteracPaymentForCustomer($data)
    {
        // Send an email:
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            $data["to"],
            33260480,
            [

                "customer" => $data["customer"],

                "amount" => $data["amount"],

                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,

            ]
        );
    }

    /**
     * Get undocumented variable
     *
     * @return  PostmarkClient
     */
    public function getPostmarkClient()
    {
        return $this->postmarkClient;
    }

    /**
     * Set undocumented variable
     *
     * @param  PostmarkClient  $postmarkClient  Undocumented variable
     *
     * @return  self
     */
    public function setPostmarkClient(PostmarkClient $postmarkClient)
    {
        $this->postmarkClient = $postmarkClient;

        return $this;
    }
}
