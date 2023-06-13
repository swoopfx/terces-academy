<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\Programs;
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

    public function businessAnalysisMasterclassAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function persionalisedInterviewPrepAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function businessAnalysisProgramAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $data = $em->find(Programs::class, 10);
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }


    public function businessCertificateProgramAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $data = $em->find(Programs::class, 20);
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }

    public function oneOnOneInterviewPrepAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $data = $em->find(Programs::class, 30);
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }

    public function buyCourseAction()
    {
        $viewModel =  new ViewModel();
        $request = $this->getRequest();
        $uuid = $this->params()->fromRoute("id", NULL);
        if ($uuid == NULL) {
            return $this->redirect()->toRoute("home");
        }

        return $viewModel;
    }




    public function careerServiceAction()
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
