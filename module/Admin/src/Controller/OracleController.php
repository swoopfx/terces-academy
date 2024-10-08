<?php

namespace Admin\Controller;

use Admin\Entity\OracleClasses;
use Application\Entity\P6MasterClassClasses;
use Application\Entity\ActiveP6Cohort;
use Application\Entity\ActiveP6CohortStatus;
use Application\Entity\ActiveP6FreeMasterclassCohort;
use Application\Entity\ActiveUserProgram;
use Application\Entity\ActiveUserProgramStatus;
use Application\Entity\P6Cohort;
use Application\Entity\P6FreeCohort;
use Application\Entity\Programs;
use Application\Service\ZoomService;
use Authentication\Entity\User;
use Authentication\Service\UserService;
use Doctrine\ORM\EntityManager;
use General\Entity\RoomType;
use General\Service\PostMarkService;
use Internship\Entity\P6Room;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;
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

    /**
     * zoom service
     *
     * @var ZoomService
     */
    private ZoomService $zoomService;

    /**
     * Undocumented variable
     *
     * @var PostMarkService
     */
    private PostMarkService $postmarkService;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->layout()->setTemplate("admin-layout");
    }

    public function freeMasterClassCohortAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function oracleP6Action()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function createFreeMasterClassCohortAction()
    {
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
                    $cohortEntity = new P6FreeCohort();
                    $startDate = \DateTime::createFromFormat("Y-m-d", $data["stDate"]);
                    $cohortEntity->setCreatedOn(new \DateTime())
                        ->setCohortName($data["cohort_name"])
                        ->setUuid(Uuid::uuid4()->toString())
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
        $response->setStatusCode(500);
        return $jsonModel;
    }

    public function getFreeMasterClassCohortAction()
    {
        $viewModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(P6FreeCohort::class)->createQueryBuilder("c")
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

    public function processFreeMasterclassAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    /**
     * Master Class page for processing cohort which includes creating zoom meetings for 
     * Cohort 
     *
     * @return void
     */
    public function processMasterclassAction()
    {
        $viewModel = new ViewModel();
        $uuid = $this->params()->fromRoute("id", NULL);
        $cSeed = new Container("process_seed");
        $cSeed->seed = Uuid::uuid4()->toString();
        $em = $this->entityManager;
        try {
            if ($uuid == NULL) {
                throw new \Exception("Absent identifier");
            }

            $cohort = $em->getRepository(P6FreeCohort::class)->createQueryBuilder("c")
                ->select(["c"])
                ->where("c.uuid = :uuid")
                ->setParameters([
                    "uuid" => $uuid
                ])->setMaxResults(10)->orderBy("c.id", "DESC")->getQuery()->getArrayResult();

            if ($cohort != NULL) {
                $activeMembers = $em->getRepository(ActiveP6FreeMasterclassCohort::class)
                    ->createQueryBuilder("a")
                    ->select(["a", "u", "s", "aup"])
                    ->leftJoin("a.user", "u")
                    ->leftJoin("a.cohort", "p")
                    ->leftJoin("a.status", "s")
                    ->leftJoin("a.activeUserProgram", "aup")
                    ->where("p.id = :p6")
                    ->setParameters([
                        "p6" => $cohort[0]["id"]
                    ])
                    ->getQuery()
                    ->getArrayResult();
            }


            $viewModel->setVariables([
                "cohort" => $cohort[0],
                "students" => $activeMembers,
                "seed" => $cSeed->seed
            ]);
            // get all Zoom resources 
        } catch (\Throwable $th) {
            //throw $th;
            var_dump($th->getMessage());
        }
        return $viewModel;
    }

    public function createZoomEventAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $post = $request->getPost()->toArray();
        // var_dump($post);
        if ($request->isPost()) {
            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'eventDate',
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
                                'isEmpty' => 'Event Date is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'duration',
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
                                'isEmpty' => 'Duration is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'classRoomId',
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
                                'isEmpty' => 'Classrom is required'
                            ]
                        ]
                    ]
                ]
            ]);


            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $user = $this->identity();
                $data = $inputFilter->getValues();
                $eventDate = \DateTime::createFromFormat("Y-m-d\TH:i", $data["eventDate"]);
                $zoom_data["date_time"] = $eventDate;
                $zoom_data["user_email"] = $user->getEmail();
                $zoom_data["agenda"] = "Oracle P6 ";
                $zoom_data["duration"] = $data["duration"];
            }
            // var_dump($eventDate);
        }
        return $jsonModel;
    }

    public function createContentAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function contentRoomAction()
    {
        $viewModel = new ViewModel();
        $uuid = $this->params()->fromRoute("id", NULL);
        $em = $this->entityManager;
        try {
            if ($uuid == NULL) {
                throw new \Exception("Absent identifier");
            }

            $cohort = $em->getRepository(P6Cohort::class)->createQueryBuilder("c")
                ->select(["c"])
                ->where("c.uuid = :uuid")
                ->setParameters([
                    "uuid" => $uuid
                ])->setMaxResults(10)->orderBy("c.id", "DESC")->getQuery()->getArrayResult();


            $activeMembers = $em->getRepository(ActiveP6Cohort::class)
                ->createQueryBuilder("a")
                ->select(["a", "p", "u", "s", "aup"])
                ->leftJoin("a.user", "u")
                ->leftJoin("a.p6Cohort", "p")
                ->leftJoin("a.status", "s")
                ->leftJoin("a.activeUserProgram", "aup")
                ->where("p.id = :p6")
                ->setParameters([
                    "p6" => $cohort[0]["id"]
                ])
                ->getQuery()
                ->getArrayResult();

            $viewModel->setVariables([
                "cohort" => $cohort[0],
                "students" => $activeMembers
            ]);
            // get all Zoom resources 
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $viewModel;
    }

    public function getZoomRoomTypeAction()
    {
        $jsonModel = new JsonModel();

        return $jsonModel;
    }

    public function getOracleClassesAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(OracleClasses::class)->createQueryBuilder("o")
            ->select("o")->getQuery()->getArrayResult();
        $jsonModel->setVariables(["data" => $data]);
        return $jsonModel;
    }

    public function getMasterclassAssignedStatusAction()
    {
        $em = $this->entityManager;
        $id = $this->params()->fromQuery("cohort", NULL);
        $jsonModel = new JsonModel();
        $data = $em->getRepository(ActiveP6FreeMasterclassCohort::class)->createQueryBuilder("a")
            ->select(["a"])->where("a.cohort = :cohort")->setParameters([
                "cohort" => $id
            ])->getQuery()->getArrayResult();
        // ->findBy([
        //     "cohort" => $id
        // ]);

        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function getMasterclassClassesAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(P6MasterClassClasses::class)->createQueryBuilder("o")
            ->select("o")->getQuery()->getArrayResult();
        $jsonModel->setVariables(["data" => $data]);
        return $jsonModel;
    }

    /**
     * Asssign cohort to students
     *
     * @return void
     */
    public function assignAllStudentToMasterClassAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $cSeed = new Container("process_seed");
        $em = $this->entityManager;

        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            try {
                if ($post["seed"] != $cSeed->seed) {
                    throw new \Exception("Invalid Seed");
                }

                // $allActiveUserProgram = $em->getRepository(ActiveUserProgram::class)->findBy([
                //     "program" => $post["program"]
                // ]);



                $activeCohortEntity = P6FreeCohort::class;
                $activeBusinessMassterClassCohortEntity = new ActiveP6FreeMasterclassCohort(); // ActiveBusinessMasterclassCohort();
                $activeBusinessMassterClassCohortEntity->setCreatedOn(new \Datetime())
                    ->setCohort($em->find($activeCohortEntity, $post["cohort"]))->setIsActive(TRUE)
                    ->setProgram($em->find(Programs::class, $post["program"]))
                    ->setUuid(Uuid::uuid4()->toString())->setIsAll(TRUE);

                $em->persist($activeBusinessMassterClassCohortEntity);
                $em->flush();

                // trigger notification to all registered user 

                $response->setStatusCode(201);
                $jsonModel->setVariables([
                    "success" => TRUE
                ]);
            } catch (\Throwable $th) {
                $response->setStatusCode(423);
                $jsonModel->setVariables([
                    "message" => $th->getMessage()
                ]);
            }
        }
        return $jsonModel;
    }

    public function retriveClassroomDetailsAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        try {
            $params = $this->params()->fromQuery();
            // var_dump($params);
            if ($params["oracle_class"] == NULL || $params["cohort"] == NULL || $params["room_type"] == NULL) {
                throw new \Exception("Required parameter is NULL");
            }
            $data = $em->getRepository(P6Room::class)
                ->createQueryBuilder("r")->select(["r", "p", "rt", "oc"])
                ->leftJoin("r.p6cohort", "p")
                ->leftJoin("r.roomType", "rt")
                ->leftJoin("r.oracleClasses", "oc")
                ->where("p.id = :cohort")
                ->andWhere("rt.id = :room_type")
                ->andWhere("oc.id = :oracle_class")
                ->setParameters([
                    "cohort" => $params["cohort"],
                    "room_type" => $params["room_type"],
                    "oracle_class" => $params["oracle_class"]
                ])
                ->getQuery()
                ->getArrayResult();

            $jsonModel->setVariables([
                "data" => $data
            ]);
            return $jsonModel;
        } catch (\Throwable $th) {
            //throw $th;
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "message" => $th->getMessage()
            ]);
        }
        return $jsonModel;
    }

    // public function get

    /**
     * Assigns a user to oracle cohort
     *
     * @return void
     */
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
                    $cohortEntity = $em->find(P6Cohort::class, $values["cohort"]);
                    $activeUserProgramEntity->setStatus($em->find(ActiveUserProgramStatus::class, 150))->setUpdatedOn(new \Datetime());
                    $activeP6OracleEntity = new ActiveP6Cohort();
                    $activeP6OracleEntity->setCreatedOn(new \Datetime())
                        ->setUser($activeUserProgramEntity->getUser())
                        ->setUuid(Uuid::uuid4()->toString())
                        ->setIsActive(TRUE)
                        ->setStatus($em->find(ActiveP6CohortStatus::class, 10))
                        ->setP6Cohort($cohortEntity)
                        ->setActiveUserProgram($activeUserProgramEntity);

                    $em->persist($activeUserProgramEntity);
                    $em->persist($activeP6OracleEntity);
                    $em->flush();

                    $mailData["to"] = $activeUserProgramEntity->getUser()->getEmail();
                    $mailData["name"] = $activeUserProgramEntity->getUser()->getFullname();
                    $mailData["cohort"] = $cohortEntity->getCohortName();
                    $mailData["program"] = $activeUserProgramEntity->getProgram()->getTitle();
                    $this->postmarkService->assignedUserToCohort($mailData);

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

    public function getAssignedCohortAction()
    {
        $jsonModel = new JsonModel();
        $cohort = $this->params()->fromQuery("ch", NULL);
        $response = $this->getResponse();
        try {
            if ($cohort == NULL) {
                throw new \Exception("Absent Identifier");
            }

            $em = $this->entityManager;
            $query = $em->getRepository(ActiveP6Cohort::class)->createQueryBuilder("a")
                ->select(["a", "p", "u", "ass", "aup"])
                ->leftJoin("a.p6Cohort", "p")
                ->leftJoin("a.user", "u")
                ->leftJoin("a.status", "ass")
                ->leftJoin("a.activeUserProgram", "aup")
                ->where("p.id = :cohort")
                ->setParameters([
                    "cohort" => $cohort
                ])
                ->getQuery()
                ->getArrayResult();

            $jsonModel->setVariables([
                "data" => $query
            ]);
            $response->setStatusCode(200);
        } catch (\Throwable $th) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "message" => $th->getMessage()
            ]);
        }

        return $jsonModel;
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

    public function getRoomTypesAction()
    {
        $viewModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(RoomType::class)->createQueryBuilder("c")
            ->select(["c"])
            ->where("c.isActive = :active")
            ->setParameters([
                "active" => TRUE
            ])->setMaxResults(10)->orderBy("c.id", "ASC")->getQuery()->getArrayResult();
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
     * used to assign an interuser to oracle p6 cohort
     *
     * @return void
     */
    public function assignInteracUserAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            try {
                $keyword = $post["keyword"];
                // $query = $this->params()->fromQuery();
                // $keyword = $query["keyword"];
                $qb = $em->createQueryBuilder();
                $data = $qb->select([
                    "partial tag.{id, uuid, email, fullname, uid}",
                    "partial r.{id, name}"
                ])->from(User::class, "tag")
                    ->leftJoin("tag.role", "r")
                    ->where($qb->expr()->orX(
                        $qb->expr()->like('tag.email', ':title'),
                        $qb->expr()->like('tag.username', ':title'),
                        $qb->expr()->like('tag.fullname', ':title')
                    ))
                    // ->andWhere("r.id = :role")
                    ->andWhere($qb->expr()->orX(
                        $qb->expr()->like('r.id', ':role1'),
                        $qb->expr()->like('r.id', ':role2')
                        // $qb->expr()->like('tag.fullname', ':title')
                    ))
                    ->setParameters([
                        'title' => '%' . $keyword . '%',
                        "role1" => UserService::USER_ROLE_CUSTOMER,
                        "role2" => UserService::USER_ROLE_ORACLE_P6
                    ])->getQuery()->getArrayResult();
                $viewModel->setVariables([
                    "success" => true,
                    "data" => $data
                ]);
                return $viewModel;
            } catch (\Throwable $th) {
                $viewModel->setVariables([
                    "success" => false,
                    "message" => $th->getMessage()
                ]);
                $response->setStatusCode(400);
                return $viewModel;
            }
        }
        $viewModel->setVariables([
            "success" => false,
            "data" => NULL
        ]);
        return $viewModel;
    }

    /**
     * Used to effect the assignment of interac payment for 
     * oracle p6 too the program and cohort
     *
     * @return void
     */
    public function effectAssignInteracUserAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();

            //payment made

            //Assign to cohort
            try {
                //code...
            } catch (\Throwable $th) {
                $jsonModel->setVariables([
                    "message" => $th->getMessage(),
                    "success" => false,
                ]);
            }
        }
        return $jsonModel;
    }

    /**
     * Used to search for  users 
     *
     * @return void
     */
    public function searchUserAction()
    {
        $jsonModel = new JsonModel();

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

    /**
     * Set zoom service
     *
     * @param  ZoomService  $zoomService  zoom service
     *
     * @return  self
     */
    public function setZoomService(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;

        return $this;
    }

    /**
     * Set undocumented variable
     *
     * @param  PostMarkService  $postmarkService  Undocumented variable
     *
     * @return  self
     */
    public function setPostmarkService(PostMarkService $postmarkService)
    {
        $this->postmarkService = $postmarkService;

        return $this;
    }
}
