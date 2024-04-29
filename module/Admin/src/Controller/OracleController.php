<?php

namespace Admin\Controller;

use Application\Entity\ActiveP6Cohort;
use Application\Entity\ActiveP6CohortStatus;
use Application\Entity\ActiveUserProgram;
use Application\Entity\ActiveUserProgramStatus;
use Application\Entity\P6Cohort;
use Doctrine\ORM\EntityManager;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Ramsey\Uuid\Uuid;

class OracleController extends AbstractActionController
{

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private EntityManager $entityManager;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->layout()->setTemplate("admin-layout");
    }

    public function createContentAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function contentRoomAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function assignToCohortAction()
    {
        $viewModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $em = $this->entityManager;
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'cohort',
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
                                'isEmpty' => 'Cohort is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'activeUserProgram',
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
                                'isEmpty' => 'Active User Program is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                try {
                    $values = $inputFilter->getValues();
                    $activeUserProgramEntity = $em->find(ActiveUserProgram::class, $values["activeUserProgram"]);

                    $activeP6OracleEntity = new ActiveP6Cohort();
                    $activeP6OracleEntity->setCreatedOn(new \Datetime())
                        ->setUser($activeUserProgramEntity->getUser())
                        ->setUuid(Uuid::uuid4())
                        ->setIsActive(TRUE)
                        ->setStatus($em->find(ActiveP6CohortStatus::class, 10))
                        ->setP6Cohort($em->find(P6Cohort::class, $values["cohort"]))
                        ->setActiveUserProgram($activeUserProgramEntity);

                    $em->persist($activeP6OracleEntity);
                    $em->flush();

                    $response->setStatusCode(201);
                } catch (\Throwable $th) {
                    $response->setStatusCode(423);
                    $viewModel->setVariables([
                        "message" => $th->getMessage()
                    ]);
                }
            } else {
                $response->setStatusCode(423);
                $viewModel->setVariables([
                    "message" => $inputFilter->getMessages()
                ]);
            }
        }
        return $viewModel;
    }

    public function registeredUsersAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $data = $em->getRepository(ActiveUserProgram::class)
            ->createQueryBuilder("a")
            ->select(["a", "u"])
            ->innerJoin("a.user", "u")
            ->where("a.program = :program")
            ->andWhere("a.isActive = :active")
            ->setParameters([
                "active" => TRUE,
                "program" => 40
            ])->getQuery()->getArrayResult();
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }

    public function viewAction()
    {
        $viewModel = new ViewModel();
        $uuid = $this->params()->fromRoute("id", NULL);
        try {
            if ($uuid == NULL) {
                throw new \Exception("No Identifier");
            }
            $em = $this->entityManager;
            // $data = $em->getRepository(ActiveUserProgram::class)->findOneBy([
            //     "uuid" => $uuid
            // ]);
            $data = $em->getRepository(ActiveUserProgram::class)
                ->createQueryBuilder("a")
                ->select(["a", "p", "u", "s",  "oraclech", "p6Cohort"])
                ->leftJoin("a.user", "u")
                ->leftJoin("a.program", "p")
                ->leftJoin("a.oracleCohort", "oraclech")
                ->leftJoin("oraclech.p6Cohort", "p6Cohort")
                // ->leftJoin("", "")
                ->leftJoin("a.status", "s")
                // ->leftJoin("a.paidInstallment", "paidInstallement")
                ->where("a.uuid = :uuid")
                ->andWhere("a.isActive = :active")
                ->setParameters([
                    "active" => TRUE,
                    "uuid" => $uuid
                ])->getQuery()->getArrayResult();

            $viewModel->setVariables([
                "data" => $data[0]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            // var_dump($th->getMessage());
            $this->flashMessenger()->addErrorMessage($th->getMessage());
            $url = $this->getRequest()->getHeader('Referer')->getUri();
            return $this->redirect()->toUrl($url);
        }

        return $viewModel;
    }

    public function createCohortAction()
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
                    $cohortEntity = new P6Cohort();
                    $startDate = \DateTime::createFromFormat("Y-m-d", $data["stDate"]);
                    $cohortEntity->setCreatedOn(new \DateTime())
                        ->setCohort($data["cohort_name"])
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

    public function getCohortAction()
    {
        $viewModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(P6Cohort::class)->createQueryBuilder("c")
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

    public function deactivateCohortAction()
    {
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $uuid = $this->params()->fromRoute("id", NULL);
        try {
            $em = $this->entityManager;
            if ($uuid != NULL) {
                /**
                 * @var P6Cohort
                 */
                $data = $em->getRepository(P6Cohort::class)->findOneBy([
                    "uuid" => $uuid
                ]);
                if ($data == NULL) {
                    throw new \Exception("NO Cohort to deactivate");
                } else {
                    $data->setIsActive(False);
                    $em->persist($data);
                    $em->flush();
                    $response->setStatusCode(202);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            $response->setStatusCode(434);
            $jsonModel->setVariables([
                "message" => $th->getMessage()
            ]);
        }
        return $jsonModel;
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
