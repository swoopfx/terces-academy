<?php

namespace General\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use General\Entity\Settings;

class GeneralService
{

    const GENERAL_TRAINING_FREE = "Free Business Analysis Master Class";

    const GENERAL_TRAINING_FREE_ORACLE_P6 = "Free ORACLE P6 Master Class";

    const GENERAL_TRAINING_WORK_EXPERIENCE = "Business Analysis- Self Study";

    const GENERAL_TRAINING_CERTIFICATE_PROGRAM = "Business Analysis Certification Program";

    const GENERAL_TRAINING_INTERVIEW_PREP = "One on One Interview Prep";

    const GENERAL_INTERNSHIP_ON_JOB_TRAINING = "Business Analysis - on the job training";

    const GENERAL_ORACLE_P6 = "Primavera P6 Enterprise Project Portfolio Management";

    const GENERAL_INTERNSHIP_PRICE = 1500;


    const ACTIVE_USER_PROGRAM_STATUS_ACQUIRED = 100;

    const ACTIVE_USER_PROGRAM_STATUS_ASSIGNED_COHORT = 150;

    const ACTIVE_USER_PROGRAM_STATUS_STARTED_COURSE = 200;

    const ACTIVE_USER_PROGRAM_STATUS_COMPLETED_COURSE = 300;

    const ACTIVE_USER_PROGRAM_STATUS_CACELED_COURSE = 400;


    const COMPANY_NAME = "Terces Academy";

    const COMPANY_ADDRESS = "";

    const MAX_PAGE_COUNT = 50;

    const INTERNSHIP_INSTALLMENT = "+4 week";


    const ADMISSIONS_SEND_MONEY_INITIATED = 100;

    const ADMISSION_SEND_MONEY_COMPLETED = 200;



    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Undocumented variable
     *
     * @var AuthenticationService 
     */
    private $auth;


    /**
     * Undocumented variable
     *
     * @var Settings
     */
    private $settings;



    /**
     * Get undocumented variable
     *
     * @return  EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set undocumented variable
     *
     * @param  EntityManager  $entityManager  Undocumented variable
     *
     * @return  self
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  AuthenticationService
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Set undocumented variable
     *
     * @param  AuthenticationService  $auth  Undocumented variable
     *
     * @return  self
     */
    public function setAuth(AuthenticationService $auth)
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Settings
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set undocumented variable
     *
     * @param  Settings  $settings  Undocumented variable
     *
     * @return  self
     */
    public function setSettings(Settings $settings)
    {
        $this->settings = $settings;

        return $this;
    }
}
