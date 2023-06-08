<?php

declare(strict_types=1);

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function aboutAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function courseListAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function courseDetailsAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function contactAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function mentorsAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function programAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function allCourseAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function course()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    // public function 

    /**
     * Get the value of entityManager
     *
     * @return  EntityManager
     */ 
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set the value of entityManager
     *
     * @param  EntityManager  $entityManager
     *
     * @return  self
     */ 
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
