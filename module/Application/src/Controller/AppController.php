<?php

namespace Application\Controller;

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


    public function paypalCapturePaymentAction()
    {
        $jsonModel = new jsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
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
}
