<?php
namespace Internship\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ToolsController extends AbstractActionController{

    public function toolsAction(){
        
        $viewModel = new ViewModel();
        return $viewModel;
    }
}