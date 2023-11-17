<?php

namespace Admissions\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;

class SendmoneyController extends AbstractActionController
{

    /**
     * Undocumented variable
     *
     * @var array
     */
    private $config;


    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->layout()->setTemplate("admissions/layout");
        return $response;
    }

    public function indexAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            "public_key" => $this->config["stripe"]["publishable_key"],
            'url' => $this->config["uurl"]
        ]);
        
        return $viewModel;
    }

    /**
     * Set undocumented variable
     *
     * @param  array  $config  Undocumented variable
     *
     * @return  self
     */ 
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }
}
