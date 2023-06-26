<?php

namespace General\Service;

use Postmark\PostmarkClient;

class PostMarkService {


    /**
     * Undocumented variable
     *
     * @var PostmarkClient
     */
    private $postmarkClient;

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