<?php
namespace Internship\Controller;

use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ToolsController extends AbstractActionController{

    private EntityManager $entityManager;

    public function toolsAction(){
        
        $viewModel = new ViewModel();
        // echo 
        return $viewModel;
    }

    /**
     * Set the value of entityManager
     *
     * @return  self
     */ 
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}