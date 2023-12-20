<?php

namespace Internship\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Internship\Entity\Projects;

class ProjectController extends AbstractActionController
{
    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;

    private $generalService;

    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function getProjectsAction(){
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(Projects::class)->createQueryBuilder("p")->select("p")
        return $jsonModel;
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
