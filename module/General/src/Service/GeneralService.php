<?php

namespace General\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;

class GeneralService
{
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
