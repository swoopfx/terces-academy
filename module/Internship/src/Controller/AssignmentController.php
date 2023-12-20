<?php

namespace Internship\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AssignmentController extends  AbstractActionController{


    public function indexAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}