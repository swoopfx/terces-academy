<?php


namespace General\Service;

use General\Service\GeneralService;

class ActiveCampaignService
{

    /**
     * Undocumented variable
     *
     * @var GeneralService
     */
    private $generalService;

    private $activeInstance;


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
