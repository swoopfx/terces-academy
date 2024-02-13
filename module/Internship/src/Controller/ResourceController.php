<?php

namespace  Internship\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ResourceController extends AbstractActionController{
    
    public function indexAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}