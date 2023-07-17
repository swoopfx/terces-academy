<?php

namespace Application\Controller;


use Laminas\Mvc\Controller\AbstractActionController;
use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;

class AdminController extends AbstractActionController
{

    /**
     * Undocumented variable
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;

    // private $

    public function indexAction()
    {
    }

    public function customerListAction()
    {
    }

    public function customerDetailsAction()
    {
    }

    public function trainingListAction()
    {
    }

    public function viewTrainingAction()
    {
    }

    public function addCourseAction()
    {
    }

    public function editCourseAction()
    {
    }

    public function removeCourseAction()
    {
    }

    public function addCourseVideoAction()
    {
    }

    public function editCourseVideoAction()
    {
    }

    public function removeCourseVideoAction()
    {
    }

    

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
     * @return  GeneralService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * Set undocumented variable
     *
     * @param  GeneralService  $generalService  Undocumented variable
     *
     * @return  self
     */
    public function setGeneralService(GeneralService $generalService)
    {
        $this->generalService = $generalService;

        return $this;
    }
}
