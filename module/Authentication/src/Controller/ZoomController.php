<?php

namespace Authentication\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;

class ZoomController extends AbstractActionController
{

    public function authAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }
}
