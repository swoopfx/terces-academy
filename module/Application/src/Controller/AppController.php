<?php

namespace Application\Controller;

use Application\Entity\NewsLetter;
use General\Service\ActiveCampaignService;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;

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
}
