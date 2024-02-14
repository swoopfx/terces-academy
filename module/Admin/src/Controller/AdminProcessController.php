<?php

namespace Admin\Controller;

use Application\Entity\InternshipCohort;
use Doctrine\ORM\EntityManager;
use Internship\Entity\Assignments;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class AdminProcessController extends AbstractActionController
{

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;


    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function createAssignmentAction()
    {
        $em = $this->entityManager;
        $jsonmodel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost();
            $inputFilter = new InputFilter();

            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $values = $inputFilter->getValues();
                $assignmentsEntity = new Assignments();
                $assignmentsEntity->setCohort($em->find(InternshipCohort::class, $values["cohort"]))
                    ->setCreatedOn(new \DateTime())->setUpdatedOn(new \Datetime())
                    ->setContent($values["content"]);
            }
        }
        return $jsonmodel;
    }

    /**
     * Get undocumented variable
     *
     * @return  EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set undocumented variable
     *
     * @param  EntityManager  $entityManager  Undocumented variable
     *
     * @return  self
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
