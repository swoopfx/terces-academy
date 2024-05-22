<?php

namespace Admin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ProgramsController extends AbstractActionController
{


    public function selfstudyAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function onjobTrainingAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function certificationAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function oracleAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function careerServiceAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }
}
