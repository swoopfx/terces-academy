<?php

namespace Admissions\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AdmissionsController extends AbstractActionController
{

    public function indexAction()
    {
        $viewModel = new ViewModel();
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
