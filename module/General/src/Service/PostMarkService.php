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
                "company_name" => "company_name_Value",
                "company_address" => "company_address_Value",
                "name" => "name_Value",

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
