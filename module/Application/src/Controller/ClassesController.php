<?php
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ClassesController extends AbstractActionController{


    public function indexAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}