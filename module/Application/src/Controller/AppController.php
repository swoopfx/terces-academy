<?php

namespace Application\Controller;

use Application\Entity\InteracPayment;
use Application\Entity\NewsLetter;
use Application\Entity\PaymentMethod;
use Application\Entity\Programs;
use General\Service\ActiveCampaignService;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Laminas\Session\Container;
use Application\Service\TransactionService;
use Application\Service\PaystackService;
use Ramsey\Uuid\Uuid;
use General\Service\PostMarkService;
use Application\Service\StripeService;
use Doctrine\ORM\Query;

class AppController extends  AbstractActionController
{


    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Undocumented variable
     *
     * @var ActiveCampaignService
     */
    private $activeCampaignService;

    /**
     * Undocumented variable
     *
     * @var TransactionService
     */
    private $transactionService;

    /**
     * Undocumented variable
     *
     * @var array
     */
    private $paystackConfig;

    /**
     * Undocumented variable
     *
     * @var PaystackService
     */
    private $paystackService;

    /**
     * Undocumented variable
     *
     * @var PostMarkService
     */
    private $postmarkService;

    /**
     * Undocumented variable
     *
     * @var StripeService
     */
    private $stripeService;

    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function joinNewsLetterAction()
    {
        $jsonModel = new JsonModel();
        $newsLetterEntity = new NewsLetter();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost();
            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'email',
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
                                'isEmpty' => 'Email is required'
                            ]
                        ]
                    ],
                    [
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => [
                            'use_context' => true,
                            'object_repository' => $this->entityManager->getRepository(NewsLetter::class),
                            'object_manager' => $this->entityManager,
                            'fields' => [
                                'email'
                            ],
                            'messages' => [

                                NoObjectExists::ERROR_OBJECT_FOUND => 'You are already registered on our newsleter'
                            ]
                        ]
                    ],
                ]
            ]);

            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                try {
                    $data = $inputFilter->getValues();
                    $newsLetterEntity->setEmail($data["email"])->setCreatedOn(new \Datetime());

                    $activeCampaignData = [
                        "email" => $data["email"],
                        "firstname" => "",
                        "lastname" => "",
                        "phone" => "",
                    ];

                    // call active campaign newsletter
                    $activeResponse = $this->activeCampaignService->createContact($activeCampaignData);
                    $newsLetterEntity
                        ->setActiveCampaignId($activeResponse["id"])
                        ->setActiveCampaignResponseData($activeResponse["data"]);
                    $activeCampaignList = [
                        "list" => 2,
                        "contact" => $activeResponse["id"]
                    ];
                    $this->activeCampaignService->updateContactList($activeCampaignList);
                    $this->entityManager->persist($newsLetterEntity);
                    $this->entityManager->flush();

                    $response->setStatusCode(201);
                } catch (\Throwable $th) {
                    $jsonModel->setVariables([
                        "message" => $th->getMessage(),
                    ]);
                    $response->setStatusCode(400);
                }
            } else {
                $jsonModel->setVariables([
                    "message" => json_encode($inputFilter->getMessages()),
                ]);
                $response->setStatusCode(400);
            }
        }
        return $jsonModel;
    }

    public function referAction()
    {
        $viewModel = new ViewModel();
        $referContainer = new Container("refer");
        $url = $this->getRequest()->getHeader('Referer')->getUri();

        $referContainer->refer = $url;

        return $this->redirect()->toRoute("register");
        // return $viewModel;
    }


    public function getAllProgramsAction()
    {
        $entityManager = $this->entityManager;
        $request = $this->getRequest();

        $response = $this->getResponse();
        $data = $entityManager->getRepository(Programs::class)
            ->createQueryBuilder("p")->select(["p as program", "c as courses", "cc as course_content"])
            ->where("p.isActive = :active")
            ->leftJoin("p.courses", "c")
            ->leftJoin("c.courseContent", "cc")
            ->setParameters([
                "active" => true
            ])->getQuery()->getArrayResult();

        return new JsonModel([
            "data" => $data,
        ]);
    }

    public function getPaymentMethodsAction()
    {
        $jsonModel  = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(PaymentMethod::class)->createQueryBuilder("p")
            ->select(["p"])
            ->where("p.isActive = :active")->setParameters([
                "active" => TRUE
            ])->getQuery()->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function getPaystackPublicKeyAction()
    {
        $jsonModel = new JsonModel();
        $jsonModel->setVariables([
            "public_key" => $this->paystackConfig["public_key"]
        ]);
        return $jsonModel;
    }

    public function initPaystackAction()
    {
        $jsonModel = new JsonModel();

        $request = $this->getRequest();
        $response = $this->getResponse();

        try {
            $data = $this->paystackService->intiatializeTransaction();
            $data["public_key"] = $this->paystackConfig["public_key"];
            $jsonModel->setVariables($data);
            $response->setStatusCode(201);
        } catch (\Throwable $th) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "trace" => $th->getTrace(),
                "message" => $th->getMessage()
            ]);
        }

        return $jsonModel;
    }

    public function initPaystackNairaAction()
    {
        $jsonModel = new JsonModel();

        $request = $this->getRequest();
        $response = $this->getResponse();

        try {
            $data = $this->paystackService->intiatializeTransactionNaira();
            $data["public_key"] = $this->paystackConfig["public_key"];
            $jsonModel->setVariables($data);
            $response->setStatusCode(201);
        } catch (\Throwable $th) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "trace" => $th->getTrace(),
                "message" => $th->getMessage()
            ]);
        }

        return $jsonModel;
    }

    public function initInternshipPaystackNairaAction()
    {
        $jsonModel = new JsonModel();

        $request = $this->getRequest();
        $response = $this->getResponse();


        try {
            $data = $this->paystackService->intiatializeInternshipTransactionNaira();
            $data["public_key"] = $this->paystackConfig["public_key"];
            $jsonModel->setVariables($data);
            $response->setStatusCode(201);
        } catch (\Throwable $th) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "trace" => $th->getTrace(),
                "message" => $th->getMessage()
            ]);
        }

        return $jsonModel;
    }


    public function verifyPaystackAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post  = $request->getPost()->toArray();

            try {
                if ($post["reference"] == NULL) {
                    throw new \Exception("Absent payment reference");
                }
                $data = $this->paystackService->verifyTrasaction($post);
                $response->setStatusCode(201);
                $jsonModel->setVariables([]);
            } catch (\Throwable $th) {
                //throw $th;
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "trace" => $th->getTrace(),
                    "message" => $th->getMessage()
                ]);
            }
        }
        return $jsonModel;
    }

    public function sendInteracAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $em = $this->entityManager;
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'email',
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
                                'isEmpty' => 'Interac Email is required'
                            ]
                        ]
                    ],

                ]
            ]);

            $inputFilter->add([
                'name' => 'amount',
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
                                'isEmpty' => 'Amount paid is required'
                            ]
                        ]
                    ],

                ]
            ]);

            $inputFilter->add([
                'name' => 'program',
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
                                'isEmpty' => 'Program paid is required'
                            ]
                        ]
                    ],

                ]
            ]);

            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                try {
                    $auth = $this->identity();
                    $values = $inputFilter->getValues();
                    $interacEntity = new InteracPayment();
                    $interacEntity->setUuid(Uuid::uuid4())
                        ->setCreatedOn(new \Datetime())
                        ->setUser($auth)
                        ->setProgram($em->find(Programs::class, $values["program"]))
                        ->setInteracEmail($values["email"])
                        ->setAmount($values["amount"]);

                    $em->persist($interacEntity);
                    $em->flush();

                    $adminMail = [
                        "to" => "app@tercesjobs.com",
                        "sender_name" => $auth->getFullname(),
                        "amount" => $values["amount"],
                        "admin" => "Terces Academy"
                    ];

                    $adminMail2 = [
                        "to" => "Emuveyanoghenetejiri@gmail.com",
                        "sender_name" => $auth->getFullname(),
                        "amount" => $values["amount"],
                        "admin" => "Terces Academy"
                    ];

                    $customerMail = [
                        "to" => $auth->getEmail(),
                        "customer" => $auth->getFullname(),
                        "amount" => $values["amount"],
                    ];

                    $this->postmarkService->initiatedInteracPaymentForAdmin($adminMail);
                    $this->postmarkService->initiatedInteracPaymentForAdmin($adminMail2);
                    $this->postmarkService->initiatedInteracPaymentForCustomer($customerMail);


                    $response->setStatusCode(201);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        "message" => $th->getMessage()
                    ]);
                }
            }
        }
        return $jsonModel;
    }


    public function initiateStripePaymentAction()
    {
        $jsonModel = new JsonModel();

        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            try {
                $post = $request->getContent();
                $decoded = json_decode($post, true);
                // $data = $this->paystackService->intiatializeTransaction();
                $data = $this->stripeService->init($decoded["items"][0]);
                // $data["public_key"] = $this->paystackConfig["public_key"];

                $intentSession = new Container("intent_session");
                $intentSession->intent = $data["clientSecret"];
                $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                $response->setContent(json_encode($data));
                return $response;
            } catch (\Throwable $th) {
                $response->setStatusCode(400);
                // $jsonModel->setVariables([
                //     "trace" => $th->getTrace(),
                //     "message" => $th->getMessage()
                // ]);
                var_dump($th->getMessage());
                return $response;
            }
        }


        return $jsonModel;
    }

    public function initiateStripeinstallementPaymentAction()
    {
        $jsonModel = new JsonModel();

        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            try {
                $post = $request->getContent();
                $decoded = json_decode($post, true);
                // $data = $this->paystackService->intiatializeTransaction();
                // var_dump($decoded);
                $data = $this->stripeService->initInstallment($decoded["items"][0]);
                // $data["public_key"] = $this->paystackConfig["public_key"];

                $intentSession = new Container("intent_session");
                $intentSession->intent = $data["clientSecret"];
                $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                $response->setContent(json_encode($data));
                return $response;
            } catch (\Throwable $th) {
                $response->setStatusCode(400);
                // $jsonModel->setVariables([
                //     "trace" => $th->getTrace(),
                //     "message" => $th->getMessage()
                // ]);
                // var_dump($th->getMessage());
                return $response;
            }
        }


        return $jsonModel;
    }

    public function finalizeStripePaymentAction()
    {
        $viewModel = new ViewModel();

        $request = $this->getRequest();
        $response = $this->getResponse();
        $query = $this->params()->fromQuery();
        $intentSession = new Container("intent_session");
        if ($intentSession->intent == $query["payment_intent_client_secret"]) {
            try {
                // $data = $this->paystackService->intiatializeTransaction();\

                $data = $this->stripeService->final();
                return $this->redirect()->toRoute("app", ["action" => "stripe-success"]);
            } catch (\Throwable $th) {
                $response->setStatusCode(400);
                $viewModel->setVariables([
                    "trace" => $th->getTrace(),
                    "message" => $th->getMessage()
                ]);
                return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
            }
        } else {
            return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
        }
        return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
    }


    public function finalizeCareerServicePaymentAction()
    {
        $viewModel = new JsonModel();;

        $request = $this->getRequest();
        $response = $this->getResponse();
        $query = $this->params()->fromQuery();
        // $intentSession = new Container("intent_session");
        $sess  = new Container("career_service_schedule");
        $uuid = $sess->uuid;
        if ($uuid != NULL) {
            try {
                // $data = $this->paystackService->intiatializeTransaction();\

                $data = $this->stripeService->finalCareerService();
                return $this->redirect()->toRoute("app", ["action" => "stripe-success"]);
            } catch (\Throwable $th) {
                $response->setStatusCode(400);
                $viewModel->setVariables([
                    // "trace" => $th->getTraceAsString(),
                    "message" => $th->getMessage()
                ]);
                return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
            }
        } else {
            return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
        }
        // return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
        return $viewModel;
    }


    public function finalizeInternshipPaymentAction()
    {
        $viewModel = new JsonModel();;

        $request = $this->getRequest();
        $response = $this->getResponse();
        $query = $this->params()->fromQuery();
        // $intentSession = new Container("intent_session");
        $sess = new Container("internship_payment");
        $id = $sess->cohort;
        if ($id != NULL) {
            try {
                // $data = $this->paystackService->intiatializeTransaction();\

                $data = $this->stripeService->finalInternshhip();
                return $this->redirect()->toRoute("app", ["action" => "stripe-success"]);
            } catch (\Throwable $th) {
                $response->setStatusCode(400);
                $viewModel->setVariables([
                    // "trace" => $th->getTraceAsString(),
                    "message" => $th->getMessage()
                ]);
                // return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
            }
        } else {
            return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
        }
        // return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
        return $viewModel;
    }

    public function finalizeInternshipPaystackPaymentAction()
    {
        $viewModel = new JsonModel();;

        $request = $this->getRequest();
        $response = $this->getResponse();
        // $query = $this->params()->fromQuery();
        // $intentSession = new Container("intent_session");
        $sess = new Container("internship_payment");
        $id = $sess->cohort;
        if ($request->isPost()) {
            $post = $request->getPost();
            if ($post != NULL && $id != NULL) {
                $fulldata = json_decode($post["data"], true);

                try {
                    $this->paystackService->verifyinternshipTrasaction($fulldata);

                    $data = $this->stripeService->finalInternshhip();
                    $ped = $this->params()->fromQuery("ped", NULL);
                    if ($ped == "ix") {
                        $jsonModel = new JsonModel();
                        $response->setStatusCode(201);
                        return $jsonModel;
                    }
                    return $this->redirect()->toRoute("app", ["action" => "stripe-success"]);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $viewModel->setVariables([
                        // "trace" => $th->getTraceAsString(),
                        "message" => $th->getMessage()
                    ]);
                    // return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
                }
            } else {
                return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
            }
        }

        // return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
        return $viewModel;
    }

    public function finalizeStripeInstallmentPaymentAction()
    {
        $viewModel = new ViewModel();

        $request = $this->getRequest();
        $response = $this->getResponse();
        $query = $this->params()->fromQuery();
        $intentSession = new Container("intent_session");
        if ($intentSession->intent == $query["payment_intent_client_secret"]) {
            try {
                // $data = $this->paystackService->intiatializeTransaction();\
                // $json = $request->getContent();
                // $data = json_decode($json, true);
                $data = $this->stripeService->finalInstallment();
                return $this->redirect()->toRoute("app", ["action" => "stripe-success"]);
            } catch (\Throwable $th) {
                $response->setStatusCode(400);
                $viewModel->setVariables([
                    "trace" => $th->getTrace(),
                    "message" => $th->getMessage()
                ]);
                var_dump($th->getMessage());
                var_dump($th->getTrace());
                // return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
            }
        } else {
            return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
        }
        return $this->redirect()->toRoute("app", ["action" => "stripe-error"]);
    }

    public function stripeSuccessAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function stripeErrorAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }


    public function preTransactionAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $inputData = [];
        try {
            $data = $this->transactionService->preTransaction($inputData);
            $response->setStatusCode(201);
            $jsonModel->setVariables([
                "data" => $data
            ]);
        } catch (\Throwable $th) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "desc" => $th->getMessage()
            ]);
        }
        return $jsonModel;
    }


    public function paypalCreateOrderAction()
    {

        $jsonModel = new jsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        try {
            $data =  $this->transactionService->paypalCreateOrder();
            // $jsonModel->setVariable("data", $data);
            // $response->setStatusCode(201);

            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent($data);
            return $response;
        } catch (\Throwable $th) {
            //throw $th;
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "success" => false,
                "desc" => $th->getMessage()
            ]);
        }
        return $jsonModel;
    }

    public function paypalCreateInstallmentOrderAction()
    {
        $jsonModel = new jsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {

            try {
                $post = $request->getContent();
                $decoded = json_decode($post, true);
                $data =  $this->transactionService->paypalCreateInstallmentOrder($decoded["uuid"]);
                // $jsonModel->setVariable("data", $data);
                // $response->setStatusCode(201);

                $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                $response->setContent($data);
                return $response;
            } catch (\Throwable $th) {
                //throw $th;
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "success" => false,
                    "desc" => $th->getMessage()
                ]);
            }
        }

        return $jsonModel;
    }


    public function paypalCapturePaymentAction()
    {
        $jsonModel = new jsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $json = $request->getContent();
            $data = json_decode($json, true);
            try {
                $data =  $this->transactionService->paypalConfirmOrder($data);
                // $jsonModel->setVariable("data", $data);
                // $response->setStatusCode(201);

                $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                $this->flashMessenger()->addSuccessMessage("You have successfully paid for the Service please continue with you training");
                // $response->setContent($data);
                $response->setStatusCode(201);
                return $response;
            } catch (\Throwable $th) {
                //throw $th;
                $response->setStatusCode(400);
                // var_dump($th->getMessage());
                // $jsonModel->setVariables([
                //     "success" => false,
                //     "desc" => $th->getMessage()
                // ]);
            }
        }

        return $jsonModel;
    }



    public function paypalCaptureInstallmentPaymentAction()
    {
        $jsonModel = new jsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $json = $request->getContent();
            $data = json_decode($json, true);
            try {
                $data =  $this->transactionService->paypalConfirmInstallmentOrder($data);
                // $jsonModel->setVariable("data", $data);
                // $response->setStatusCode(201);

                $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                $this->flashMessenger()->addSuccessMessage("You have successfully paid for the Service please continue with you training");
                // $response->setContent($data);
                $response->setStatusCode(201);
                return $response;
            } catch (\Throwable $th) {
                //throw $th;
                $response->setStatusCode(400);
                // var_dump($th->getMessage());
                // $jsonModel->setVariables([
                //     "success" => false,
                //     "desc" => $th->getMessage()
                // ]);
            }
        }

        return $jsonModel;
    }

    public function getProgramsForTirdpartyAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $repo = $em->getRepository(Programs::class);
        $data = $repo->createQueryBuilder("p")
            ->select([
                "p"
            ])->orderBy("p.id", "DESC")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        $jsonModel->setVariables([
            "data" => $data
        ]);
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Access-Control-Allow-Origin', '*');
        $response->getHeaders()->addHeaderLine('Access-Control-Allow-Credentials', 'true');
        $response->getHeaders()->addHeaderLine('Access-Control-Allow-Methods', 'GET');

        return $jsonModel;
    }

    /**
     * Get the value of entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set the value of entityManager
     *
     * @return  self
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  ActiveCampaignService
     */
    public function getActiveCampaignService()
    {
        return $this->activeCampaignService;
    }

    /**
     * Set undocumented variable
     *
     * @param  ActiveCampaignService  $activeCampaignService  Undocumented variable
     *
     * @return  self
     */
    public function setActiveCampaignService(ActiveCampaignService $activeCampaignService)
    {
        $this->activeCampaignService = $activeCampaignService;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  TransactionService
     */
    public function getTransactionService()
    {
        return $this->transactionService;
    }

    /**
     * Set undocumented variable
     *
     * @param  TransactionService  $transactionService  Undocumented variable
     *
     * @return  self
     */
    public function setTransactionService(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  array
     */
    public function getPaystackConfig()
    {
        return $this->paystackConfig;
    }

    /**
     * Set undocumented variable
     *
     * @param  array  $paystackConfig  Undocumented variable
     *
     * @return  self
     */
    public function setPaystackConfig(array $paystackConfig)
    {
        $this->paystackConfig = $paystackConfig;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  PaystackService
     */
    public function getPaystackService()
    {
        return $this->paystackService;
    }

    /**
     * Set undocumented variable
     *
     * @param  PaystackService  $paystackService  Undocumented variable
     *
     * @return  self
     */
    public function setPaystackService(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  PostMarkService
     */
    public function getPostmarkService()
    {
        return $this->postmarkService;
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

    /**
     * Get undocumented variable
     *
     * @return  StripeService
     */
    public function getStripeService()
    {
        return $this->stripeService;
    }

    /**
     * Set undocumented variable
     *
     * @param  StripeService  $stripeService  Undocumented variable
     *
     * @return  self
     */
    public function setStripeService(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;

        return $this;
    }
}

