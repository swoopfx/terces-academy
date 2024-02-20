<?php

namespace Admin\Controller;

use Admin\Entity\ZoomVideo;
use Application\Entity\InternshipCohort;
use Application\Entity\InternshipRegister;
use Doctrine\ORM\EntityManager;
use General\Service\UploadService;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\Validator\File\Extension;
use Laminas\Validator\File\Size;
use General\Entity\Image;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Ramsey\Uuid\Uuid;

class InternshipController extends AbstractActionController
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
     * @var UploadService
     */
    private UploadService $uploadService;


    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->layout()->setTemplate("admin-layout");
    }

    public function totalRegisteredAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(InternshipRegister::class)
            ->createQueryBuilder("s")
            ->select("count(s.id)")->getQuery()->getSingleScalarResult();
        $jsonModel->setVariable("total", $data);
        return $jsonModel;
    }


    public function totalActiveAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(InternshipRegister::class)
            ->createQueryBuilder("s")
            ->select("count(s.id)")->getQuery()->getSingleScalarResult();
        $jsonModel->setVariable("total", $data);
        return $jsonModel;
    }

    public function uploadVideoAction()
    {
        $viewModel = new ViewModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $em = $this->entityManager;
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $files = $request->getFiles()->toArray();
            $merge = array_merge($post, $files);
            $inputFilter = new InputFilter();

            $inputFilter->add([
                "name" => "video",
                'required' => true,
                'validators' => [      // Validators.
                    [
                        'name' => Extension::class,
                        'options' => [
                            'extension' => 'mov, avi, mp4',
                            'message' => 'File extension not match',
                        ],
                    ],
                    // [
                    //     'name' => MimeType::class,
                    //     'options' => [
                    //         'mimeType' => 'text/xls', 'text/xlsx',
                    //         'message' => 'File type not match',
                    //     ],
                    // ],
                    [
                        'name' => Size::class,
                        'options' => [
                            'min' => '1kB',  // minimum of 1kB
                            'max' => '1024MB',
                            'message' => 'File too large',
                        ],
                    ],
                ]
            ]);

            $inputFilter->add([
                "name" => "title",
                'required' => true,
                "allow_empty" => false,
                "filters" => [
                    [
                        "name" => StripTags::class
                    ],
                    [
                        "name" => StringTrim::class
                    ]
                ],
                'validators' => [      // Validators.


                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Please provide  a title'
                            )
                        )
                    ),
                ]
            ]);

            $inputFilter->add([
                "name" => "descs",
                'required' => true,
                "allow_empty" => false,
                "filters" => [
                    [
                        "name" => StripTags::class
                    ],
                    [
                        "name" => StringTrim::class
                    ]
                ],
                'validators' => [      // Validators.


                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Please provide  a breif Description about the video'
                            )
                        )
                    ),
                ]
            ]);
            $inputFilter->add([
                "name" => "cohort",
                'required' => true,
                "allow_empty" => false,
                "filters" => [
                    [
                        "name" => StripTags::class
                    ],
                    [
                        "name" => StringTrim::class
                    ]
                ],
                'validators' => [      // Validators.


                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Please select a cohort associated with this video'
                            )
                        )
                    ),
                ]
            ]);

            $jsonModel = new JsonModel();
            $inputFilter->setData($merge);
            if ($inputFilter->isValid()) {
                $data = $inputFilter->getValues();
                try {
                    // $data["keyname"] = "academy";zoomVideoEntity
                    /**
                     * @var Image
                     */
                    $res = $this->uploadService->uploadLarge($data);
                    $zoomVideoEntity = new ZoomVideo();
                    $zoomVideoEntity->setTitles($data["title"])
                        ->setCreatedOn(new \Datetime())
                        ->setDescs($data["descs"])
                        ->setUuid(Uuid::uuid4())
                        ->setIsActive(true)
                        ->setVideo($res)
                        ->setCohort($em->find(InternshipCohort::class, $data["cohort"]));
                    $em->persist($zoomVideoEntity);
                    $em->flush();
                    $response->setStatusCode(201);
                    return $jsonModel;
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        "message" => $th->getMessage()
                    ]);
                    return $jsonModel;
                }
            } else {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "message" => $inputFilter->getMessages()
                ]);
                return $jsonModel;
            }
        }

        return $viewModel;
    }


    public function getRecentVideoAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(ZoomVideo::class)->createQueryBuilder("z")->select(["z.titles", "c.cohort", "z.createdOn"])
            ->leftJoin("z.cohort", "c")
            ->where("z.isActive = :active")
            ->setParameters([
                "active" => TRUE
            ])
            ->setMaxResults(5)
            ->getQuery()->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function trainingVideosAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
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
