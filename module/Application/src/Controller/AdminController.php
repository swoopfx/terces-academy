<?php

namespace Application\Controller;

use Application\Entity\ActiveUserProgram;
use Application\Entity\CourseContent;
use Application\Entity\Courses;
use Application\Entity\Programs;
use Authentication\Entity\User;
use Authentication\Service\UserService;
use Laminas\Mvc\Controller\AbstractActionController;
use General\Service\GeneralService;
use General\Service\UploadService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\MvcEvent;
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

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->layout()->setTemplate("admin-layout");
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
            $order = ($this->params()->fromQuery("order", NULL) == null ? "DESC" : "ASC");
            $pageCount = ($this->params()->fromQuery("page_count", 40) > 100 ? 100 : $this->params()->fromQuery("page_count", 40));
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

            // var_dump($th->getTrace());
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
            $orderBy = $this->params()->fromQuery("order_by", "id");
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
                        ->setId($value["id"])
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
        $data  = $em->createQueryBuilder()->select(["cc", "c", "b"])
            ->from(CourseContent::class, "cc")
            ->leftJoin("cc.courses", "c")
            ->leftJoin("cc.banner", "b")
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
                        ->setId($value["id"])
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
}
