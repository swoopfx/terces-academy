<?php

namespace Admissions\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;

class PortalController extends AbstractActionController
{

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->layout()->setTemplate("admissions/layout");
        return $response;
    }

    public function indexAction()
    {
        $viewModel = new ViewModel();
    }
}
