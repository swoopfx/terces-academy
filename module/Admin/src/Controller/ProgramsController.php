<?php

namespace Admin\Controller;

use Application\Entity\ActiveBusinessMasterclassCohort;
use Application\Entity\ActiveUserProgram;
use Application\Entity\ActiveZoomClassId;
use Application\Entity\CertificationsCohort;
use Application\Entity\InternshipCohort;
use Application\Entity\MasterClassClasses;
use Application\Entity\MasterClassCohort;
use Application\Entity\Programs;
use Application\Entity\ZoomMeetingResponse;
use Application\Service\ZoomService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Func;
use General\Service\GeneralService;
use Internship\Entity\InternshipResource;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Ramsey\Uuid\Uuid;

class ProgramsController extends AbstractActionController
{

    /**
     * Undocumented variable
     * 
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * Undocumented variable
     *
     * @var ZoomService
     */
    private ZoomService $zoomService;


    public function getZoomClassAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $cohort = $this->params()->fromQuery("cohort", NULL);
        $program = $this->params()->fromQuery("program", NULL);
        try {
            if ($cohort == NULL || $program == NULL) {
                throw new \Exception("Absent ID");
            }

            $zoomClassQuery = $em->getRepository(ZoomMeetingResponse::class)
                ->createQueryBuilder("a")
                ->select(["a", "p", "c"])->leftJoin("a.program", "p")->where("a.program = :program");
            if ($program == 4) {
                $zoomClassQuery->leftJoin("a.freeBusinessMasterClassCohort", "c");
                $zoomClassQuery->andWhere("a.freeBusinessMasterClassCohort = :cohort");
            } elseif ($program == 10) {
                $zoomClassQuery->leftJoin("a.businessAnalysisCohort", "c");
                $zoomClassQuery->andWhere("a.businessAnalysisCohort = :cohort");
            } elseif ($program == 40) {
                $zoomClassQuery->leftJoin("a.oracleP6Cohort", "c");
                $zoomClassQuery->andWhere("a.oracleP6Cohort = :cohort");
            }

            $data = $zoomClassQuery->setParameters([
                "program" => $program,
                "cohort" => $cohort
            ])->getQuery()->getArrayResult();

            $jsonModel->setVariables([
                "data" => $data
            ]);
        } catch (\Throwable $th) {
            $jsonModel->setVariables([
                "message" => $th->getMessage()
            ]);
            $response->setStatusCode(400);
        }
        return $jsonModel;
    }


    public function getResosAction()
    {
        $jsonModel = new JsonModel();
        $roomType = $this->params()->fromQuery("roomtype", NULL);
        $cohortId = $this->params()->fromQuery("cohortid", NULL);
        $em = $this->entityManager;
        $query = $em->getRepository(InternshipResource::class)->createQueryBuilder("i")
            ->select(["i", "c", "m", "r", "rt"])
            ->leftJoin("i.cohort", "c")
            ->leftJoin("i.masterClassCohort", "m")
            ->leftJoin("i.resos", "r")
            ->leftJoin("i.roomType", "rt");
        // ->where("rt.id = :roomTypeId");

        // if($roomType == 100){
        //     // Resources Room Type
        //     $query->where("rt.id = :roomType")->setParameters([

        //     ])
        // }

        return $jsonModel;
    }


    public function getAssignedStatusAction()
    {
        $em = $this->entityManager;
        $id = $this->params()->fromQuery("cohort", NULL);
        $jsonModel = new JsonModel();
        $data = $em->getRepository(ActiveBusinessMasterclassCohort::class)->createQueryBuilder("a")
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



                $activeCohortEntity = MasterClassCohort::class;
                $activeBusinessMassterClassCohortEntity = new ActiveBusinessMasterclassCohort();
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

    /**
     * 
     * Send Out zoom event
     * @return void
     */
    public function sendZoomEventsAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function freeMasterClassAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function freeMasterClassCohortAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function getMasterclassClassesAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(MasterClassClasses::class)->createQueryBuilder("o")
            ->select("o")->getQuery()->getArrayResult();
        $jsonModel->setVariables(["data" => $data]);
        return $jsonModel;
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
                    $cohortEntity = new MasterClassCohort();
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
        $data = $em->getRepository(MasterClassCohort::class)->createQueryBuilder("c")
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

            $cohort = $em->getRepository(MasterClassCohort::class)->createQueryBuilder("c")
                ->select(["c"])
                ->where("c.uuid = :uuid")
                ->setParameters([
                    "uuid" => $uuid
                ])->setMaxResults(10)->orderBy("c.id", "DESC")->getQuery()->getArrayResult();

            if ($cohort != NULL) {
                $activeMembers = $em->getRepository(ActiveBusinessMasterclassCohort::class)
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

    public function createMasterClassEventAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $post = $request->getPost()->toArray();
        $em = $this->entityManager;
        // var_dump($post);
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
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
                try {

                    $data = $inputFilter->getValues();
                    $programEntity = $em->find(Programs::class, $post["program"]);
                    $eventDate = \DateTime::createFromFormat("Y-m-d\TH:i", $data["eventDate"]);
                    $zoom_data["date_time"] = $eventDate;
                    $zoom_data["user_email"] = $user->getEmail();
                    $zoom_data["agenda"] = $programEntity->getTitle();
                    $zoom_data["duration"] = $data["duration"];
                    $zoom_data["user_name"] = $user->getFullname();
                    $zoom_data["program"] = $post["program"];
                    $zoom_data["cohort"] = $post["cohort"];
                    $zoom_data["classRoomId"] = $post["classRoomId"];

                    // var_dump($zoom_data);
                    // exit();

                    $this->zoomService->createMeeting($zoom_data);

                    $response->setStatusCode(201);
                    $jsonModel->setVariables([
                        "success" => true
                    ]);
                } catch (\Throwable $th) {
                    $response->setStatusCode(423);
                    $jsonModel->setVariables([
                        "message" => $th->getMessage()
                    ]);
                }
            } else {
                $response->setStatusCode(423);
                $jsonModel->setVariables([
                    "message" => $inputFilter->getMessages()
                ]);
            }
            // var_dump($eventDate);
        }
        return $jsonModel;
    }

    public function sendInvitaionsAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $zoom_data["program"] = $post["program"];
            $zoom_data["cohort"] = $post["cohort"];
            try {
                $this->zoomService->resendZoomEvent($zoom_data);

                $response->setStatusCode(202);
            } catch (\Throwable $th) {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "message" => $th->getMessage()
                ]);
            }
        }
        return $jsonModel;
    }

    public function userAction()
    {
        $viewModel = new ViewModel();
        $ext = $this->params()->fromQuery("ext", NULL);

        $viewModel->setVariables([
            "ext" => $ext
        ]);
        return $viewModel;
    }

    public function getRegisteredUserAction()
    {
        $jsonModel  = new JsonModel();
        $em = $this->entityManager;
        $parameters["active"] = TRUE;
        $ext = $this->params()->fromQuery("ext", NULL);
        $max = $this->params()->fromQuery("max", NULL);
        $query = $em->getRepository(ActiveUserProgram::class)
            ->createQueryBuilder("a")->select(["a", "u", "p", "s", "p6", "cc", "mc", "us"])
            ->leftJoin("a.user", "u")
            ->leftJoin("u.state", "us")
            ->leftJoin("a.program", "p")
            ->leftJoin("a.status", "s")
            ->leftJoin("a.oracleCohort", "p6")
            ->leftJoin("a.certificationCohort", "cc")
            ->leftJoin("a.masterClassCohort", "mc")
            ->where("a.isActive = :active");

        if ($ext != NULL) {
            $query->andWhere("p.id = :programId");
            $parameters["programId"] = $ext;
        }

        $data = $query->setParameters($parameters)
            ->orderBy("a.id", "DESC")
            ->setMaxResults($max ?? 40)
            ->getQuery()
            ->getArrayResult();

        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function getActiveZoomClassAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $query = $this->params()->fromQuery();
        try {
            if ($query["program"] == NULL || $query["cohort"] == NULL) {
                throw new \Exception("Absent Identifier");
            }
            $data = $em->getRepository(ActiveZoomClassId::class)->createQueryBuilder("a")
                ->select(["a", "p"])->leftJoin("a.program", "p")
                ->where("p.id = :programId")
                ->andWhere("a.cohort = :cohort")->setParameters([
                    "programId" => $query["program"],
                    "cohort" => $query["cohort"]
                ])->getQuery()->getArrayResult();

            $jsonModel->setVariables([
                "data" => $data
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

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

    public function onjobTrainingAsignedCohortAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function onjobCohortAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function processCohortAction()
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

            $cohort = $em->getRepository(InternshipCohort::class)->createQueryBuilder("c")
                ->select(["c"])
                ->where("c.id = :uuid")
                ->setParameters([
                    "uuid" => $uuid
                ])->setMaxResults(10)->orderBy("c.id", "DESC")->getQuery()->getArrayResult();

            if ($cohort != NULL) {
                $activeMembers = $em->getRepository(ActiveBusinessMasterclassCohort::class)
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
                    $cohortEntity = new InternshipCohort();
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
        $response->setStatusCode(500);
        return $jsonModel;
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

    /**
     * Set undocumented variable
     *
     * @param  ZoomService  $zoomService  Undocumented variable
     *
     * @return  self
     */
    public function setZoomService(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;

        return $this;
    }
}
