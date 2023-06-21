<?php

namespace General\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;

class GeneralService
{

    const GENERAL_TRAINING_FREE = "Business Analysis Free Hands on training";

    const GENERAL_TRAINING_WORK_EXPERIENCE = "Business Analysis Work Experience Program";

    const GENERAL_TRAINING_CERTIFICATE_PROGRAM = "Business Analysis Certification Program";

    const GENERAL_TRAINING_INTERVIEW_PREP = "Business Analysis interview Preparation";
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
}
