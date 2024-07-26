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

    public function newOnTheJobTrainingRegister($data)
    {
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            $data["to"],
            36321447,
            [

                "product_name" => $data["product_name"],
                "organization_name" => GeneralService::COMPANY_NAME,
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,
                "name" => $data["name"],
                "link1" => $data["link1"],
                "link2" => $data["link2"],
                "link3" => $data["link3"],
                "link4" => $data["link4"]
            ]
        );
    }

    public function freeBusinessAnalysisMasterClassRegister($data)
    {
        // Send an email:
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            $data["to"],
            36465788,
            [

                "product_name" => $data["product_name"],
                "organization_name" => GeneralService::COMPANY_NAME,
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,
                "name" => $data["name"],

            ]
        );
    }

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

    public function adminUserCreation($data)
    {
        // Send an email:
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            $data["to"],
            34800507,
            [

                "action_url" => $data["link"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,
                // "name_value" => 
                "product_url" => "https://academy.tercesjobs.com/",
                "product_name" => GeneralService::COMPANY_NAME,
                "name" => $data["name"],
                "invite_sender_name" => "The Administrator",
                "invite_sender_organization_name" => GeneralService::COMPANY_NAME,

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

    public function resetPassword($data)
    {
        // Send an email:
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            $data["to"],
            33366369,
            [


                "product_name" => "Terces Academy",
                "name" => $data["toName"],
                "action_url" => $data["fulllink"],

                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,



            ]
        );
    }

    public function customerCareerTalkNotification($data)
    {
        // Send an email:
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            $data["to"],
            33550635,
            [


                "product_name" => "Terces Academy",
                "name" => $data["name"],
                // "action_url" => $data["fulllink"],
                "sch_date" => $data["sch_date"],
                "sch_time" => $data["sch_time"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,



            ]
        );
    }

    public function adminCareerTalkNotification($data)
    {
        // Send an email:
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            "Emuveyanoghenetejiri@gmail.com",
            33551173,
            [


                "product_name" => "Terces Academy",
                "name" => $data["name"],
                "admin" => "Admin",
                "sch_date" => $data["sch_date"],
                "sch_time" => $data["sch_time"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,



            ]
        );
    }


    public function welcomeOnjobTraining($data)
    {
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            "Emuveyanoghenetejiri@gmail.com",
            33551173,
            [


                "product_name" => "Terces Academy",
                "name" => $data["name"],
                "admin" => "Admin",
                "sch_date" => $data["sch_date"],
                "sch_time" => $data["sch_time"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,



            ]
        );
    }

    public function welcomeCareerService($data)
    {
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            "Emuveyanoghenetejiri@gmail.com",
            33551173,
            [


                "product_name" => "Terces Academy",
                "name" => $data["name"],
                "admin" => "Admin",
                "sch_date" => $data["sch_date"],
                "sch_time" => $data["sch_time"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,



            ]
        );
    }

    public function welcomeCertification($data)
    {
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            "Emuveyanoghenetejiri@gmail.com",
            33551173,
            [


                "product_name" => "Terces Academy",
                "name" => $data["name"],
                "admin" => "Admin",
                "sch_date" => $data["sch_date"],
                "sch_time" => $data["sch_time"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,



            ]
        );
    }

    public function welcomeOracle($data)
    {
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            "Emuveyanoghenetejiri@gmail.com",
            33551173,
            [


                "product_name" => "Terces Academy",
                "name" => $data["name"],
                "admin" => "Admin",
                "sch_date" => $data["sch_date"],
                "sch_time" => $data["sch_time"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,



            ]
        );
    }

    public function welcomeSelfstudy($data)
    {
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            "Emuveyanoghenetejiri@gmail.com",
            33551173,
            [


                "product_name" => "Terces Academy",
                "name" => $data["name"],
                "admin" => "Admin",
                "sch_date" => $data["sch_date"],
                "sch_time" => $data["sch_time"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,



            ]
        );
    }

    //
    public function manySendZoomMeetingNotification($data)
    {
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            "Emuveyanoghenetejiri@gmail.com",
            36543184,
            [
                "topic" => $data["topic"],
                "join" => $data["join"],
                "start_time" => $data["start_time"],
                "meeting_id" => $data["meeting_id"],
                "password" => $data["password"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,

            ],
            true,
            null,
            null,
            null,
            null,
            $data["bcc"], //imploded array
            null,

        );
    }


    public function manySendZoomMeetingReminder($data)
    {
        $sendResult = $this->postmarkClient->sendEmailWithTemplate(
            "app@tercesjobs.com",
            "Emuveyanoghenetejiri@gmail.com",
            36589911,
            [
                "topic" => $data["topic"],
                "join" => $data["join"],
                "start_time" => $data["start_time"],
                "meeting_id" => $data["meeting_id"],
                "password" => $data["password"],
                "company_name" => GeneralService::COMPANY_NAME,
                "company_address" => GeneralService::COMPANY_ADDRESS,

            ],
            true,
            null,
            null,
            null,
            null,
            $data["bcc"], //imploded array
            null,

        );
    }

    // Begin Batch Processing


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
