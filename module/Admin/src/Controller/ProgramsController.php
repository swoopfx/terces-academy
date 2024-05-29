<?php

namespace Admin\Controller;

use Application\Entity\ActiveUserProgram;
use Application\Entity\CertificationsCohort;
use Application\Entity\InternshipCohort;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Func;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class ProgramsController extends AbstractActionController
{

    /**
     * Undocumented variable
     * 
     * @var EntityManager
     */
    private EntityManager $entityManager;

    public function getRegisteredUserAction()
    {
        $jsonModel  = new JsonModel();
        $em = $this->entityManager;
        $parameters["active"] = TRUE;
        $ext = $this->params()->fromQuery("ext", NULL);
        $max = $this->params()->fromQuery("max", NULL);
        $query = $em->getRepository(ActiveUserProgram::class)
            ->createQueryBuilder("a")->select(["a", "u", "p", "s"])
            ->leftJoin("a.user", "u")
            ->leftJoin("a.program", "p")
            ->leftJoin("a.status", "s")
            ->where("a.isActive = :active");

        if ($ext != NULL) {
            $query->andWhere("p.id = :programId");
            $parameters["programId"] = $ext;
        }

        $data = $query->setParameters($parameters)
            ->orderBy("a.id", "DESC")
            ->setMaxResults($max ?? 50)
            ->getQuery()
            ->getArrayResult();

        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->layout()->setTemplate("admin-layout");
    }

    public function selfstudyAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function onjobTrainingAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function onjobCohortAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function getOnjobCohortAction()
    {
        $viewModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(InternshipCohort::class)->createQueryBuilder("c")
            ->select(["c"])
            ->where("c.isActive = :active")
            ->setParameters([
                "active" => TRUE
            ])->setMaxResults(10)->orderBy("c.id", "DESC")->getQuery()->getArrayResult();
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }


    public function createOnjobCohortAction()
    {
    }

    public function certificationAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    // public function createCertificationCohortAction(){
    //     $jsonModel = new JsonModel();
    //     return $jsonModel;
    // }

    public function getCertificationCohortAction()
    {
        $viewModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(CertificationsCohort::class)->createQueryBuilder("c")
            ->select(["c"])
            ->where("c.isActive = :active")
            ->setParameters([
                "active" => TRUE
            ])->setMaxResults(10)->orderBy("c.id", "DESC")->getQuery()->getArrayResult();
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }

    public function certificationCohortAction()
    {
        $viewModel = new ViewModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();

            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'cohort_name',
                'required' => true,
                'break_chain_on_failure' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                        'options' => [
                            'messages' => [
                                'isEmpty' => 'Cohort name is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'stDate',
                'required' => true,
                'break_chain_on_failure' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                        'options' => [
                            'messages' => [
                                'isEmpty' => 'Cohort name is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'active',
                'required' => true,
                'break_chain_on_failure' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                        'options' => [
                            'messages' => [
                                'isEmpty' => 'Cohort name is required'
                            ]
                        ]
                    ]
                ]
            ]);
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {

                try {
                    $em = $this->entityManager;
                    $data = $inputFilter->getValues();
                    $cohortEntity = new CertificationsCohort();
                    $startDate = \DateTime::createFromFormat("Y-m-d", $data["stDate"]);
                    $cohortEntity->setCreatedOn(new \DateTime())
                        ->setCohortName($data["cohort_name"])
                        ->setIsActive(filter_var($data["active"], FILTER_VALIDATE_BOOL))
                        ->setStartDate($startDate);

                    $em->persist($cohortEntity);
                    $em->flush();

                    $response->setStatusCode(201);

                    $jsonModel->setVariables([
                        "success" => true
                    ]);
                    return $jsonModel;
                } catch (\Throwable $th) {
                    //throw $th;
                    $response->setStatusCode(500);
                    $jsonModel->setVariables([
                        "message" => $th->getMessage()
                    ]);
                    return $jsonModel;
                }
            } else {
                $response->setStatusCode(500);
                $jsonModel->setVariables([
                    "success" => false
                ]);
                return $jsonModel;
            }
        }
        return $viewModel;
    }

    public function certificationAssignToCohortAction()
    {
        $jsonModel = new JsonModel();
        // $em = 
        return $jsonModel;
    }

    public function oracleAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function careerServiceAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
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
