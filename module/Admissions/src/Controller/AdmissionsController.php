<?php

namespace Admissions\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;

class AdmissionsController extends AbstractActionController
{

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
      
    }

    public function indexAction()
    {
        if ($this->identity()) {
            return $this->redirect()->toRoute("admissions", ["action" => "intent"]);
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }


    public function dashboardAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function intentAction()
    {
        $viewModel = new ViewModel();
        $this->layout()->setTemplate("pre/admissions/layout");
        return $viewModel;
    }
}
