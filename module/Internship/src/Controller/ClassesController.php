<?php

namespace Internship\Controller;

use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ClassesController extends AbstractActionController
{

    public function hallwayAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private EntityManager $entityManager;

    public function roomAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
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
