<?php

namespace General\Service;

use Doctrine\ORM\EntityManager;

class GeneralService {


    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;

    

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
}