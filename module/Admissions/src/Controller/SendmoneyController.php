<?php

namespace Admissions\Controller;

use Admissions\Entity\CanadianBanks;
use Admissions\Entity\SendMoneyService;
use Admissions\Entity\SendMoneyStatus;
use Admissions\Entity\SentMoney;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Laminas\InputFilter\InputFilter;
use Laminas\Session\Container;

class SendmoneyController extends AbstractActionController
{

    /**
     * Undocumented variable
     *
     * @var array
     */
    private $config;

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;


    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);

        $this->layout()->setTemplate("sendmoney/layout");
        return $response;
    }

    public function sentMoneyAction()
    {

        $viewModel = new ViewModel();

        return $viewModel;
    }

    public function getSentMoneyAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $request = $this->getRequest();
        $response = $this->getResponse();
        $auth = $this->identity();
        $userId = $auth->getId();
        $data = $em->getRepository(SentMoney::class)
            ->createQueryBuilder("s")->select([
                "partial s.{id, recipientFullname, recipientInteracEmail, accountNumber, createdOn}",
                "partial u.{id, email, fullname}",
                "partial rs.{id, service}",
                "partial cb.{id, bankName}",
                "partial st.{id, status}"
            ])->leftJoin("s.user", "u")
            ->leftJoin("s.recipientService", "rs")
            ->leftJoin("s.canadianBank", "cb")
            ->leftJoin("s.status", "st")
            ->where("u.id = :id")->setParameters([
                "id" => $userId
            ])->getQuery()->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function sendMoneyBeginAction()
    {
        $viewModel = new ViewModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new InputFilter();
            $jsonModel = new JsonModel();
            $inputFilter->add([
                'name' => 'recipientFullname',
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
                                'isEmpty' => 'Fullname is required'
                            ]
                        ]
                    ],

                ]
            ]);

            $inputFilter->add([
                'name' => 'recipientFullname',
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
                                'isEmpty' => 'Fullname is required'
                            ]
                        ]
                    ],

                ]
            ]);

            $inputFilter->add([
                'name' => 'recipientService',
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
                                'isEmpty' => 'Service type is required'
                            ]
                        ]
                    ],

                ]
            ]);

            if ($post["recipientService"] == 100) {
                // interac Validation
                $inputFilter->add([
                    'name' => 'recipientInteracEmail',
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
                                    'isEmpty' => 'Service type is required'
                                ]
                            ]
                        ],

                    ]
                ]);
            } else if ($post["recipientService"] == 200) {

                // bank validation
                $inputFilter->add([
                    'name' => 'canadianBank',
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
                                    'isEmpty' => 'Canadian Bank is required'
                                ]
                            ]
                        ],

                    ]
                ]);

                $inputFilter->add([
                    'name' => 'accountNumber',
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
                                    'isEmpty' => 'Account Number is required'
                                ]
                            ]
                        ],

                    ]
                ]);
            }

            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $session = new Container("send_money_begin");
                $values = $inputFilter->getValues();
                $session->data = $values;
                $response->setStatusCode(202);
                return $jsonModel;
            }
        }
        return $viewModel;
    }

    public function sendMoneyFinalizeAction()
    {
        if (!$this->identity()) {
            return $this->redirect()->toRoute("admissions");
        }
        $viewModel = new ViewModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        $em = $this->entityManager;
        // if($request->isPost())
        $qqq = $this->params()->fromQuery("gti", NULL);
        if ($qqq != NULL && $qqq == "finite" ) {
            try {
                $session = new Container("send_money_begin");
                if ($session->data != NULL) {
                    $sData = $session->data;
                    $sMoneyEntity = new SentMoney();

                    $sMoneyEntity->setCreatedOn(new \DateTime())
                        ->setUser($this->identity())
                        ->setRecipientFullname($sData["recipientFullname"])
                        ->setStatus($em->find(SendMoneyStatus::class, GeneralService::ADMISSION_SEND_MONEY_COMPLETED))
                        ->setRecipientService($em->find(SendMoneyService::class, $sData["recipientService"]));

                    if ($sData["recipientService"] == 100) {
                        // interac Payment
                        $sMoneyEntity->setRecipientInteracEmail($sData["recipientInteracEmail"]);
                    } else if ($sData["recipientService"] == 200) {
                        $sMoneyEntity->setCanadianBank($em->find(CanadianBanks::class, $sData["canadianBank"]))
                            ->setAccountNumber($sData["accountNumber"]);
                    }

                    $em->persist($sMoneyEntity);
                    $em->flush();
                    
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }


        $viewModel->setVariables([
            "public_key" => $this->config["stripe"]["publishable_key"],
            'url' => $this->config["uurl"]
        ]);

        return $viewModel;
    }

    public function indexAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            "public_key" => $this->config["stripe"]["publishable_key"],
            'url' => $this->config["uurl"]
        ]);

        return $viewModel;
    }

    public function getSendMoneyServiceAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(SendMoneyService::class)->createQueryBuilder("ss")->select("ss")->getQuery()->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function getCanadianBanksAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(CanadianBanks::class)->createQueryBuilder("ss")->select("ss")->getQuery()->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    /**
     * Set undocumented variable
     *
     * @param  array  $config  Undocumented variable
     *
     * @return  self
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
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
}
