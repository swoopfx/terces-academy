<?php
namespace Internship\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ClassController extends AbstractActionController{

    public function roomAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}