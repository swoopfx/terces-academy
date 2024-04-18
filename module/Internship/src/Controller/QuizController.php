<?php

namespace Internship\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class QuizController extends AbstractActionController{

    public function quizAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}