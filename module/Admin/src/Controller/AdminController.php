<?php

namespace Admin\Controller;

use Application\Entity\ActiveUserProgram;
use Application\Entity\ActiveUserProgramStatus;
use Application\Entity\CourseContent;
use Application\Entity\CourseResource;
use Application\Entity\Courses;
use Application\Entity\InteracPayment;
use Application\Entity\Programs;
use Application\Entity\Quiz;
use Application\Entity\QuizAnswer;
use Application\Entity\QuizQuestion;
use Application\Entity\Resources;
use Authentication\Entity\Roles;
use Authentication\Entity\User;
use Authentication\Entity\UserState;
use Authentication\Service\UserService;
use Laminas\Mvc\Controller\AbstractActionController;
use General\Service\GeneralService;
use General\Service\UploadService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineModule\Validator\NoObjectExists;
use General\Service\ActiveCampaignService;
use General\Service\PostMarkService;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\MvcEvent;
use Laminas\Validator\StringLength;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Ramsey\Uuid\Uuid;

class AdminController extends AbstractActionController
{

    /**
     * Undocumented variable
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Undocumented variable
     *
     * @var UploadService
     */
    private $uploadService;

    private PostMarkService $postmarkService;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->layout()->setTemplate("admin-layout");
    }

    public function createUserAction()
    {
        $viewModel = new ViewModel();
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $entityManager = $this->entityManager;
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost();
            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'email',
                'break_chain_on_failure' => true,
                'required' => true,
                "allow_empty" => false,
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
                                'isEmpty' => 'Email is required'
                            ]
                        ]
                    ],
                    [
                        "name" => NoObjectExists::class,
                        "options" => [
                            "use_context" => true,
                            "object_repository" => $entityManager->getRepository(User::class),
                            "objject_manager" => $entityManager,
                            "fields" => [
                                "email"
                            ],
                            "messages" => [
                                NoObjectExists::ERROR_OBJECT_FOUND => "please use another email"
                            ]
                        ]
                    ],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'messages' => [],
                            'min' => 6,
                            'max' => 256,
                            'messages' => [
                                StringLength::TOO_SHORT => 'Try Something more longer',
                                StringLength::TOO_LONG => 'Could you really remember this long identity'
                            ]
                        ],
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'fullname',
                'break_chain_on_failure' => true,
                'required' => true,
                "allow_empty" => false,
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
                                'isEmpty' => 'Full Name is required'
                            ]
                        ]
                    ],

                    [
                        'name' => StringLength::class,
                        'options' => [
                            'messages' => [],
                            'min' => 3,
                            'max' => 256,
                            'messages' => [
                                StringLength::TOO_SHORT => 'Try Something more longer',
                                StringLength::TOO_LONG => 'Could you really remember this long identity'
                            ]
                        ],
                    ]
                ]
            ]);
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                try {
                    $data = $inputFilter->getValues();
                    $userEntity = new User();
                    $token = md5(uniqid(mt_rand(), true));
                    $uuid = Uuid::uuid4();
                    $userEntity->setCreatedOn(new \Datetime())
                        ->setRole($entityManager->find(Roles::class, UserService::USER_ROLE_CUSTOMER))
                        ->setEmail($data["email"])
                        ->setPassword(UserService::encryptPassword($data["password"]))
                        ->setEmailConfirmed(False)
                        ->setFullname($data["fullname"])
                        ->setRegistrationDate(new \Datetime())->setRegistrationToken($token)
                        ->setUuid($uuid)
                        ->setUid(uniqid())
                        ->setState($entityManager->find(UserState::class, UserService::USER_STATE_ENABLED));

                    // send a process email

                    $fulllink = $this->url()->fromRoute('auth', array(
                        'action' => 'complete-registration',
                        'id' => $userEntity->getRegistrationToken()
                    ), array(
                        'query' =>
                        array('diu' => $uuid),
                        'force_canonical' => true
                    ));

                    $emailData["to"] =  $data["email"];
                    $emailData["link"] = $fulllink;
                    $emailData["name"] = $data["fullname"];

                    $this->postmarkService->adminUserCreation($emailData);

                    // postmark mail
                    $entityManager->persist($userEntity);
                    $entityManager->flush();
                    $response->setStatusCode(201);
                    return $jsonModel;
                } catch (\Throwable $th) {
                    $jsonModel->setVariables([
                        "success" => false,
                        "message" => $th->getMessage(),
                        // "trace"=>$th->getTraceAsString()
                    ]);
                    $response->setStatusCode(400);
                    return $jsonModel;
                }
            } else {
                $jsonModel->setVariables([
                    "success" => false,
                    "message" => $th->getMessage(),
                    // "trace"=>$th->getTraceAsString()
                ]);
                $response->setStatusCode(400);
                return $jsonModel;
            }
        }

        return $viewModel;
    }

    public function internshipBoardAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function internshipCreateAssignmentAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function interacPaymentAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        try {
            $order = ($this->params()->fromQuery("order", NULL) == null ? "DESC" : "ASC");
            $pageCount = ($this->params()->fromQuery("page_count", 40) > 100 ? 100 : $this->params()->fromQuery("page_count", 40));
            $orderBy = $this->params()->fromQuery("order_by", "id");
            $query = $this->entityManager->createQueryBuilder()->select([
                "i", "u", "p"
            ])->from(InteracPayment::class, "i")
                ->leftJoin("i.user", "u")
                ->leftJoin("i.program", "p")
                ->orderBy("i.{$orderBy}", $order)
                ->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY);

            $paginator = new Paginator($query);
            $totalItems = count($paginator);

            $currentPage = ($this->params()->fromQuery("page")) ?: 1;
            $totalPageCount = ceil($totalItems / $pageCount);
            $nextPage = (($currentPage < $totalPageCount) ? $currentPage + 1 : $totalPageCount);
            $previousPage = (($currentPage > 1) ? $currentPage - 1 : 1);

            $records = $paginator->getQuery()->setFirstResult($pageCount * ($currentPage - 1))
                // ->setMaxResults($pageCount)
                ->getResult(Query::HYDRATE_ARRAY);

            $viewModel->setVariables([
                "previous_page" => $previousPage,
                "next_page" => $nextPage,
                "data" => $records
            ]);
        } catch (\Throwable $th) {

            $response->setStatusCode(400);
            $viewModel->setVariables([
                "success" => FALSE
            ]);
        }
        return $viewModel;
    }

    public function confirmInteracPaymentAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $em = $this->entityManager;
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'interac',
                'required' => true,
                'break_chain_on_failure' => true,
                'allow_empty' => false,
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
                                'isEmpty' => 'Interac Id is required'
                            ]
                        ]
                    ],

                ]
            ]);
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                try {
                    $values = $inputFilter->getValues();
                    /**
                     * @var InteracPayment
                     */
                    $interacEntity = $em->find(InteracPayment::class, $values["interac"]);
                    $interacEntity->setIsConfirmed(TRUE)->setUpdatedOn(new \Datetime());
                    $activeUserProgram = new ActiveUserProgram();
                    $activeUserProgram->setCreatedOn(new \Datetime)
                        ->setUser($interacEntity->getUser())
                        ->setProgram($interacEntity->getProgram())
                        ->setIsActive(TRUE)->setUuid(Uuid::uuid4())
                        ->setIsInstallement(FALSE)
                        ->setStatus($em->find(ActiveUserProgramStatus::class, GeneralService::ACTIVE_USER_PROGRAM_STATUS_ACQUIRED));

                    $em->persist($activeUserProgram);
                    $em->persist($interacEntity);
                    $em->flush();

                    $response->setStatusCode(201);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        "message" => $th->getMessage(),
                        "trace" => $th->getTrace()
                    ]);
                }
            } else {
            }
        }
        return $jsonModel;
    }

    public function rejectInteracPaymentAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $em = $this->entityManager;
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'interac',
                'required' => true,
                'break_chain_on_failure' => true,
                'allow_empty' => false,
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
                                'isEmpty' => 'Interac Id is required'
                            ]
                        ]
                    ],

                ]
            ]);
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                try {
                    $values = $inputFilter->getValues();
                    /**
                     * @var InteracPayment
                     */
                    $interacEntity = $em->find(InteracPayment::class, $values["interac"]);
                    $interacEntity->setIsFailed(TRUE)->setUpdatedOn(new \Datetime());
                    // $activeUserProgram = new ActiveUserProgram();
                    // $activeUserProgram->setCreatedOn(new \Datetime)
                    //     ->setUser($interacEntity->getUser())
                    //     ->setProgram($interacEntity->getProgram())
                    //     ->setIsActive(TRUE)->setUuid(Uuid::uuid4())
                    //     ->setIsInstallement(FALSE)
                    //     ->setStatus($em->find(ActiveUserProgramStatus::class, GeneralService::ACTIVE_USER_PROGRAM_STATUS_ACQUIRED));

                    // $em->persist($activeUserProgram);
                    $em->persist($interacEntity);
                    $em->flush();

                    $response->setStatusCode(201);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        "message" => $th->getMessage(),
                        "trace" => $th->getTrace()
                    ]);
                }
            } else {
            }
        }
        return $jsonModel;
    }

    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function userListAction()
    {
        $viewModel = new ViewModel();
        $userEntity = $this->identity();
        $response = $this->getResponse();
        try {
            // $order = ($this->params()->fromQuery("order", NULL) == null ? "DESC" : "ASC");
            // $pageCount = ($this->params()->fromQuery("page_count", 40) > 100 ? 100 : $this->params()->fromQuery("page_count", 40));
            // $orderBy = $this->params()->fromQuery("order_by", "id");

            $order = ($this->params()->fromQuery("order", NULL) == null ? "DESC" : "ASC");
            $pageCount = ($this->params()->fromQuery("page_count", GeneralService::MAX_PAGE_COUNT) > 100 ? 100 : $this->params()->fromQuery("page_count", GeneralService::MAX_PAGE_COUNT));
            $orderBy = $this->params()->fromQuery("order_by", "id");

            $query = $this->entityManager->createQueryBuilder()->select([
                "c", "r", "s"
            ])->from(User::class, "c")
                ->leftJoin("c.role", "r")
                ->leftJoin("c.state", "s")

                ->orderBy("c.{$orderBy}", $order)
                ->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY);

            $paginator = new Paginator($query);
            $totalItems = count($paginator);

            $currentPage = ($this->params()->fromQuery("page")) ?: 1;
            $totalPageCount = ceil($totalItems / $pageCount);
            $nextPage = (($currentPage < $totalPageCount) ? $currentPage + 1 : $totalPageCount);
            $previousPage = (($currentPage > 1) ? $currentPage - 1 : 1);

            $records = $paginator->getQuery()->setFirstResult($pageCount * ($currentPage - 1))
                ->setMaxResults($pageCount)
                ->getResult(Query::HYDRATE_ARRAY);

            $viewModel->setVariables([
                "previous_page" => $previousPage,
                "next_page" => $nextPage,
                "data" => $records
            ]);
        } catch (\Throwable $th) {

            $response->setStatusCode(400);
            $viewModel->setVariables([
                "success" => FALSE
            ]);
        }
        return $viewModel;
    }

    public function activeProgramListsAction()
    {
        $viewModel = new ViewModel();
        $userEntity = $this->identity();
        $response = $this->getResponse();
        try {
            $order = ($this->params()->fromQuery("order", NULL) == null ? "DESC" : "ASC");
            $pageCount = ($this->params()->fromQuery("page_count", 40) > 100 ? 100 : $this->params()->fromQuery("page_count", 40));
            $orderBy = $this->params()->fromQuery("order_by", "id");
            $query = $this->entityManager->createQueryBuilder()->select([
                "partial c.{id, uuid, user, program, isActive, createdOn, updatedOn}",
                "partial u.{id, fullname, username, email, role, state, emailConfirmed, uuid, uid}",
                "partial p.{id, uuid, programId, title, createdOn}",
                "partial s.{id, status}"
                // "partial s.{id, status}",
                // "partial wt.{id, type}",
                // "partial wu.{id, fullname, username, email}"
            ])->from(ActiveUserProgram::class, "c")
                ->leftJoin("c.user", "u")
                ->leftJoin("c.program", "p")
                ->leftJoin("c.status", "s")
                ->where("c.isActive = :active")
                ->setParameters([

                    // "status" => TrashBustterService::ASSIGNED_REQUEST_STATUS_COMPLETED,
                    "active" => TRUE
                ])
                ->orderBy("c.{$orderBy}", $order)
                ->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY);

            $paginator = new Paginator($query);
            $totalItems = count($paginator);

            $currentPage = ($this->params()->fromQuery("page")) ?: 1;
            $totalPageCount = ceil($totalItems / $pageCount);
            $nextPage = (($currentPage < $totalPageCount) ? $currentPage + 1 : $totalPageCount);
            $previousPage = (($currentPage > 1) ? $currentPage - 1 : 1);

            $records = $paginator->getQuery()->setFirstResult($pageCount * ($currentPage - 1))
                // ->setMaxResults($pageCount)
                ->getResult(Query::HYDRATE_ARRAY);

            $viewModel->setVariables([
                "previous_page" => $previousPage,
                "next_page" => $nextPage,
                "data" => $records
            ]);
        } catch (\Throwable $th) {

            $response->setStatusCode(400);
            $viewModel->setVariables([
                "success" => FALSE
            ]);
        }
        return $viewModel;
    }

    public function viewActiveUserProgramAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function customerDetailsAction()
    {
        $id = $this->params()->fromRoute("id", NULL);
        if ($id == NULL) {
            return $this->redirect()->toRoute();
        }
    }

    public function programListAction()
    {
        $viewModel = new ViewModel();
        try {

            $order = ($this->params()->fromQuery("order", NULL) == null ? "DESC" : "ASC");
            $pageCount = ($this->params()->fromQuery("page_count", 40) > 100 ? 100 : $this->params()->fromQuery("page_count", 40));
            $orderBy = $this->params()->fromQuery("order_by", "id");
            $query = $this->entityManager->createQueryBuilder()->select(["p"])
                ->from(Programs::class, "p")

                ->where("p.isActive = :active")

                ->setParameters([
                    "active" => TRUE,
                ])
                ->orderBy("p.{$orderBy}", $order)
                ->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY);

            $paginator = new Paginator($query);
            $totalItems = count($paginator);

            $currentPage = ($this->params()->fromQuery("page")) ?: 1;
            $totalPageCount = ceil($totalItems / $pageCount);
            $nextPage = (($currentPage < $totalPageCount) ? $currentPage + 1 : $totalPageCount);
            $previousPage = (($currentPage > 1) ? $currentPage - 1 : 1);

            $records = $paginator->getQuery()->setFirstResult($pageCount * ($currentPage - 1))
                ->setMaxResults($pageCount)
                ->getResult(Query::HYDRATE_ARRAY);

            $viewModel->setVariables([
                "previous_page" => $previousPage,
                "next_page" => $nextPage,
                "data" => $records
            ]);
        } catch (\Throwable $th) {

            // var_dump($th->getMessage());
            $this->flashMessenger()->addErrorMessage($th->getMessage());
            $url = $this->getRequest()->getHeader('Referer')->getUri();
            return $this->redirect()->toUrl($url);
        }
        return $viewModel;
    }

    public function editProgramAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $id = $this->params()->fromRoute("id", NULL);
        if ($id == NULL) {
            $this->flashMessenger()->addErrorMessage("Absent Program Identitfier");
            $url = $this->getRequest()->getHeader('Referer')->getUri();
            return $this->redirect()->toUrl($url);
        }
        $data = $em->getRepository(Programs::class)->findOneBy([
            "uuid" => $id
        ]);
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }

    public function courseListAction()
    {
        $viewModel = new ViewModel();
        $id = $this->params()->fromRoute("id", NULL);

        try {
            if ($id == NULL) {
                throw new \Exception("Invalid Course identity");
            }
            $order = ($this->params()->fromQuery("order", NULL) == null ? "ASC" : "DESC");
            $pageCount = ($this->params()->fromQuery("page_count", 40) > 100 ? 100 : $this->params()->fromQuery("page_count", 40));
            $orderBy = $this->params()->fromQuery("order_by", "order");
            $query = $this->entityManager->createQueryBuilder()->select([
                "c", "p", "b", "v"
            ])->from(Courses::class, "c")
                ->leftJoin("c.programs", "p")
                ->leftJoin("c.banner", "b")
                ->leftJoin("c.video", "v")
                ->where("p.isActive = :active")
                ->andWhere("p.uuid = :uuid")
                ->setParameters([
                    "active" => TRUE,
                    "uuid" => $id
                ])
                ->orderBy("c.{$orderBy}", $order)
                ->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY);

            $paginator = new Paginator($query);
            $totalItems = count($paginator);

            $currentPage = ($this->params()->fromQuery("page")) ?: 1;
            $totalPageCount = ceil($totalItems / $pageCount);
            $nextPage = (($currentPage < $totalPageCount) ? $currentPage + 1 : $totalPageCount);
            $previousPage = (($currentPage > 1) ? $currentPage - 1 : 1);

            $records = $paginator->getQuery()->setFirstResult($pageCount * ($currentPage - 1))
                ->setMaxResults($pageCount)
                ->getResult(Query::HYDRATE_ARRAY);

            $viewModel->setVariables([
                "previous_page" => $previousPage,
                "next_page" => $nextPage,
                "data" => $records
            ]);
        } catch (\Throwable $th) {

            // var_dump($th->getTrace());
            $this->flashMessenger()->addErrorMessage($th->getMessage());
            $url = $this->getRequest()->getHeader('Referer')->getUri();
            return $this->redirect()->toUrl($url);
            // var_dump($th->getMessage());
        }
        return $viewModel;
    }

    public function viewTrainingAction()
    {
    }

    public function addCourseAction()
    {
        $em = $this->entityManager;
        $request = $this->getRequest();
        $response = $this->getResponse();
        $jsonmodel = new JsonModel();
        if ($request->isPost()) {

            $post = $request->getPost()->toArray();
            $file = $request->getFiles()->toArray();
            $postData = \array_merge($post, $file);
            if ($post["program"] == NULL) {
                $response->setStatusCode(400);
                $jsonmodel->setVariables([
                    "messages" => "Program Isdentifier absent"
                ]);
            }

            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'title',
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
                                'isEmpty' => 'Course title is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'program',
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
                                'isEmpty' => 'Description title is required'
                            ]
                        ]
                    ]
                ]
            ]);
            $inputFilter->add([
                'name' => 'description',
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
                                'isEmpty' => 'Description title is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'banner',
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
                                'isEmpty' => 'An Image is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'video',
                'required' => false,
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
                                'isEmpty' => 'Video is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'id',
                'required' => false,
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
                                'isEmpty' => 'Id  is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->setData($postData);
            if ($inputFilter->isValid()) {
                $value = $inputFilter->getValues();

                try {

                    $bannerEntity = $this->uploadService->upload($value["banner"]);
                    $courseEntity = new Courses();
                    $courseEntity->setCreatedOn(new \Datetime())
                        ->setTitle($value["title"])
                        ->setArrange($value["id"])
                        ->setUuid(Uuid::uuid4())
                        ->setDescription($value["description"])
                        ->setBanner($bannerEntity)

                        ->setPrograms($em->find(Programs::class, $value["program"]));

                    $em->persist($courseEntity);
                    $em->flush();

                    $response->setStatusCode(201);
                    $jsonmodel->setVariables([
                        "message" => ""
                    ]);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonmodel->setVariables([
                        "message" => $th->getMessage(),
                        "desc" => $th->getTrace()
                    ]);
                }
            } else {
                $response->setStatusCode(400);
                $jsonmodel->setVariables([
                    "message" => $inputFilter->getMessages()
                ]);
            }
        }
        return $jsonmodel;
    }

    public function removeCourseResouceAction()
    {
        $jsonModel = new JsonModel();
        $id = $this->params()->fromRoute("id", NULL);
        $em = $this->entityManager;
        $response = $this->getResponse();
        if ($id == NULL) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "success" => false,
                "message" => "id absent"
            ]);
            return $jsonModel;
        }
        try {
            $resourceEntity = $em->find(CourseResource::class, $id);
            $em->remove($resourceEntity);
            $em->flush();

            $response->setStatusCode(202);
        } catch (\Throwable $th) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "success" => false,
                "message" => $th->getMessage()
            ]);
            return $jsonModel;
        }


        return $jsonModel;
    }

    public function getCourseResourcesAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $id = $this->params()->fromRoute("id", NULL);
        if ($id == NULL) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "success" => false,
                "message" => "id absent"
            ]);
            return $jsonModel;
        }

        $em = $this->entityManager;
        $data = $em->getRepository(CourseResource::class)->createQueryBuilder("r")->select(["r", "cc",  "rf"])
            ->leftJoin("r.courses", "cc")
            // ->leftJoin("r.resourceType", "rt")
            ->leftJoin("r.resourceFile", "rf")
            ->where("cc.id = :id")
            ->setParameters([
                "id" => $id
            ])->getQuery()->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function addCourseResourcesAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $em = $this->entityManager;
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $file = $request->getFiles()->toArray();
            $postData = \array_merge($post, $file);

            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name' => 'course_id',
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
                                'isEmpty' => 'Course ID is required'
                            ]
                        ]
                    ]
                ]
            ]);



            $inputFilter->add([
                'name' => 'title',
                'required' => false,
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
                                'isEmpty' => 'Title is required'
                            ]
                        ]
                    ]
                ]
            ]);
            $inputFilter->add([
                'name' => 'file',
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
                                'isEmpty' => 'A document is required'
                            ]
                        ]
                    ]
                ]
            ]);


            $inputFilter->setData($postData);
            if ($inputFilter->isValid()) {
                $value = $inputFilter->getValues();
                try {
                    $bannerEntity = $this->uploadService->upload($value["file"]);

                    $resouseEntity = new CourseResource();
                    $resouseEntity->setCreatedOn(new \Datetime())

                        ->setCourses($em->find(Courses::class, $value["course_id"]))
                        ->setResourceTitle($value["title"])
                        ->setUuid(Uuid::uuid4())
                        ->setResourceFile($bannerEntity);

                    $em->persist($resouseEntity);
                    $em->flush();
                    $response->setStatusCode(201);
                    $jsonModel->setVariables([
                        "success" => true
                    ]);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        "success" => false,
                        "message" => $th->getMessage(),
                    ]);
                }
            } else {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "success" => false,
                    "message" => $inputFilter->getMessages(),
                ]);
            }
        }
        return $jsonModel;
    }

    public function editCourseAction()
    {
    }

    public function removeCourseAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            if ($post["key"] == NULL) {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "message" => "Absent Key"
                ]);
                return $jsonModel;
            }

            try {
                $courseEntity = $em->find(Courses::class, $post["key"]);

                $em->remove($courseEntity);
                $em->flush();

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

    public function getCourseContentAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $id = $this->params()->fromRoute("id", NULL);
        $response = $this->getResponse();
        if ($id == NULL) {
            $jsonModel->setVariables([
                "message" => "Absent Identifier"
            ]);
            $response->setStatusCode(400);
        }
        $data  = $em->createQueryBuilder()->select(["cc", "c", "b", "r", "rf"])
            ->from(CourseContent::class, "cc")
            ->leftJoin("cc.courses", "c")
            ->leftJoin("cc.banner", "b")
            ->leftJoin("cc.resources", "r")
            ->leftJoin("r.resourceFile", "rf")
            ->where("c.id = :cou")
            ->setParameters([
                "cou" => $id
            ])
            ->getQuery()
            ->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function addCourseContentAction()
    {
        $em = $this->entityManager;
        $request = $this->getRequest();
        $response = $this->getResponse();
        $jsonmodel = new JsonModel();
        if ($request->isPost()) {

            $post = $request->getPost()->toArray();
            $file = $request->getFiles()->toArray();
            $postData = \array_merge($post, $file);
            if ($post["course"] == NULL) {
                $response->setStatusCode(400);
                $jsonmodel->setVariables([
                    "messages" => "Course Isdentifier absent"
                ]);
            }

            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'title',
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
                                'isEmpty' => 'Course title is required'
                            ]
                        ]
                    ]
                ]
            ]);



            $inputFilter->add([
                'name' => 'snippetVideo',
                'required' => false,
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
                                'isEmpty' => 'Snippet Video is required'
                            ]
                        ]
                    ]
                ]
            ]);
            $inputFilter->add([
                'name' => 'description',
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
                                'isEmpty' => 'Description title is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'banner',
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
                                'isEmpty' => 'An Image is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'video',
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
                                'isEmpty' => 'Video is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'course',
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
                                'isEmpty' => 'Course is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'id',
                'required' => false,
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
                                'isEmpty' => 'Id  is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->setData($postData);
            if ($inputFilter->isValid()) {
                $value = $inputFilter->getValues();

                try {

                    $bannerEntity = $this->uploadService->upload($value["banner"]);


                    $courseContentEntity = new CourseContent();
                    $courseContentEntity->setCreatedOn(new \Datetime())
                        ->setTitle($value["title"])
                        ->setArrange($value["id"])
                        ->setUuid(Uuid::uuid4())
                        ->setVideo($value["video"])
                        ->setSnippetVideo($value["snippetVideo"])
                        ->setIsActive(TRUE)
                        ->setDescription($value["description"])
                        ->setBanner($bannerEntity)
                        ->setCourses($em->find(Courses::class, $value["course"]));

                    $em->persist($courseContentEntity);
                    $em->flush();

                    $response->setStatusCode(201);
                    $jsonmodel->setVariables([
                        "message" => ""
                    ]);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonmodel->setVariables([
                        "message" => $th->getMessage(),
                        "desc" => $th->getTrace()
                    ]);
                }
            } else {
                $response->setStatusCode(400);
                $jsonmodel->setVariables([
                    "message" => $inputFilter->getMessages()
                ]);
            }
        }
        return $jsonmodel;
    }

    public function editCourseContentAction()
    {
    }

    public function removeCourseContentAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            if ($post["key"] == NULL) {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "message" => "Absent Key"
                ]);
                return $jsonModel;
            }

            try {
                $courseEntity = $em->find(CourseContent::class, $post["key"]);

                $em->remove($courseEntity);
                $em->flush();

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



    public function getContentResourcesAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $id = $this->params()->fromRoute("id", NULL);
        if ($id == NULL) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "success" => false,
                "message" => "id absent"
            ]);
            return $jsonModel;
        }

        $em = $this->entityManager;
        $data = $em->getRepository(Resources::class)->createQueryBuilder("r")->select(["r", "cc", "rt", "rf"])
            ->leftJoin("r.courseContent", "cc")
            ->leftJoin("r.resourcesType", "rt")
            ->leftJoin("r.resourceFile", "rf")
            ->where("cc.id = :id")
            ->setParameters([
                "id" => $id
            ])->getQuery()->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function removeContentResouceAction()
    {
        $jsonModel = new JsonModel();
        $id = $this->params()->fromRoute("id", NULL);
        $em = $this->entityManager;
        $response = $this->getResponse();
        if ($id == NULL) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "success" => false,
                "message" => "id absent"
            ]);
            return $jsonModel;
        }
        try {
            $resourceEntity = $em->find(Resources::class, $id);
            $em->remove($resourceEntity);
            $em->flush();

            $response->setStatusCode(202);
        } catch (\Throwable $th) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "success" => false,
                "message" => $th->getMessage()
            ]);
            return $jsonModel;
        }


        return $jsonModel;
    }

    public function addContentResourcesAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $em = $this->entityManager;
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $file = $request->getFiles()->toArray();
            $postData = \array_merge($post, $file);

            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name' => 'content_id',
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
                                'isEmpty' => 'Course ID is required'
                            ]
                        ]
                    ]
                ]
            ]);



            $inputFilter->add([
                'name' => 'title',
                'required' => false,
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
                                'isEmpty' => 'Title is required'
                            ]
                        ]
                    ]
                ]
            ]);
            $inputFilter->add([
                'name' => 'file',
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
                                'isEmpty' => 'A document is required'
                            ]
                        ]
                    ]
                ]
            ]);


            $inputFilter->setData($postData);
            if ($inputFilter->isValid()) {
                $value = $inputFilter->getValues();
                try {
                    $bannerEntity = $this->uploadService->upload($value["file"]);

                    $resouseEntity = new Resources();
                    $resouseEntity->setCreatedOn(new \Datetime())
                        ->setCourseContent($em->find(CourseContent::class, $value["content_id"]))
                        ->setResourceTitle($value["title"])
                        ->setUuid(Uuid::uuid4())
                        ->setResourceFile($bannerEntity);

                    $em->persist($resouseEntity);
                    $em->flush();
                    $response->setStatusCode(201);
                    $jsonModel->setVariables([
                        "success" => true
                    ]);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        "success" => false,
                        "message" => $th->getMessage(),
                    ]);
                }
            } else {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "success" => false,
                    "message" => $inputFilter->getMessages(),
                ]);
            }
        }
        return $jsonModel;
    }

    //. Quiz

    public function createQuizAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        $em = $this->entityManager;
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new inputFilter();
            $inputFilter->add([
                'name' => 'question',
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
                                'isEmpty' => 'A document is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'answer',
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
                                'isEmpty' => 'A document is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'course_id',
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
                                'isEmpty' => 'A document is required'
                            ]
                        ]
                    ]
                ]
            ]);

            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $value = $inputFilter->getValues();
                try {
                    // $quizEntity = new Quiz();
                    $course = $value["course_id"];
                    $quizEntity = $em->getRepository(Quiz::class)->findOneBy([
                        "course" => $course
                    ]);
                    if ($quizEntity == NULL) {
                        $quizEntity = new Quiz();
                        $quizEntity->setCreatedOn(new \Datetime())->setUuid(Uuid::uuid4())->setCourse($em->find(Courses::class, $value["course_id"]));
                    }


                    $quizQuestionEntity = new QuizQuestion();
                    $quizQuestionEntity->setCreatedOn(new \Datetime())
                        ->setUuid(Uuid::uuid4())
                        ->setQuestion($value["question"])
                        ->setQuiz($quizEntity)
                        ->setIsActive(TRUE);

                    $decodedAnswer = json_decode($value["answer"]);
                    foreach ($decodedAnswer as $ans) {
                        $quizAnswerEntity = new QuizAnswer();
                        $quizAnswerEntity->setCreatedOn(new \Datetime())
                            ->setAnswerText($ans->text)
                            ->setQuestion($quizQuestionEntity)
                            ->setIsAnswer(boolval($ans->isAnswer))
                            ->setUuid(Uuid::uuid4());
                        $em->persist($quizAnswerEntity);
                    }
                    $em->persist($quizQuestionEntity);

                    $em->persist($quizEntity);
                    $em->flush();

                    $response->setStatusCode(201);
                    $jsonModel->setVariables([
                        "success" => true
                    ]);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        "desc" => $th->getMessage()
                    ]);
                }
            }
        }
        return $jsonModel;
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

    /**
     * Get undocumented variable
     *
     * @return  GeneralService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * Set undocumented variable
     *
     * @param  GeneralService  $generalService  Undocumented variable
     *
     * @return  self
     */
    public function setGeneralService(GeneralService $generalService)
    {
        $this->generalService = $generalService;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  UploadService
     */
    public function getUploadService()
    {
        return $this->uploadService;
    }

    /**
     * Set undocumented variable
     *
     * @param  UploadService  $uploadService  Undocumented variable
     *
     * @return  self
     */
    public function setUploadService(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;

        return $this;
    }

    /**
     * Set the value of postmarkService
     *
     * @return  self
     */
    public function setPostmarkService($postmarkService)
    {
        $this->postmarkService = $postmarkService;

        return $this;
    }
}
