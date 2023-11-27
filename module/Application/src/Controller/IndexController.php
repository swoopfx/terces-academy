<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\ActiveUserProgram;
use Application\Entity\ActiveUserProgramStatus;
use Application\Entity\Coupon;
use Application\Entity\CourseContent;
use Application\Entity\Courses;
use Application\Entity\Installement;
use Application\Entity\InternshipCohort;
use Application\Entity\PaymentMethod;
use Application\Entity\Programs;
use Application\Entity\Quiz;
use Application\Entity\ScheduleCareerTalk;
use Authentication\Entity\User;
use Doctrine\ORM\EntityManager;
use Laminas\Db\Sql\Where;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Controller\Plugin\Redirect;
use Laminas\Session\Container;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Ramsey\Uuid\Uuid;
use Doctrine\Common\Collections\Collection;
use General\Service\GeneralService;
use Laminas\InputFilter\InputFilter;

class IndexController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Undocumented variable
     *
     * @var array
     */
    private $config;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function aboutAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function courseListAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function courseDetailsAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function contactAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function mentorsAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function programAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function allCourseAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function course()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function businessAnalysisMasterclassAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }


    public function getSectionOneAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        $em = $this->entityManager;
        $data = $em->getRepository(CourseContent::class)->createQueryBuilder("cc")
            ->select(["cc", "c"])
            ->leftJoin("cc.courses", "c")

            ->where("c.id = :id")
            ->setParameters([
                "id" => 3
            ])->getQuery()->getArrayResult();

        $jsonModel->setVariables([
            "data" => $data
        ]);

        return $jsonModel;
    }

    public function persionalisedInterviewPrepAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function businessAnalysisProgramAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $data = $em->find(Programs::class, 10);
        // $data = $em->getRepository(Programs::)
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }


    public function businessCertificateProgramAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $data = $em->find(Programs::class, 20);
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }

    public function oneOnOneInterviewPrepAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $data = $em->find(Programs::class, 30);
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }

    public function buyCourseAction()
    {
        $viewModel =  new ViewModel();
        $em = $this->entityManager;
        $request = $this->getRequest();
        $uuid = $this->params()->fromRoute("id", NULL);
        $couponCode = $this->params()->fromQuery("poc", NULL);
        $coupon = "";
        if ($couponCode != NULL) {
            $coupon = $em->getRepository(Coupon::class)
                ->createQueryBuilder("c")
                ->select("c")
                ->where("c.coupon = :co")
                ->andWhere("c.isUsed = :uus")
                ->setParameters([
                    "co" => $couponCode,
                    "uus" => FALSE,
                ])->getQuery()->getArrayResult();
            $coupon =  $coupon == NULL ? NULL : $coupon[0];
        }
        if ($uuid == NULL) {
            return $this->redirect()->toRoute("home");
        }
        $buyCourseSession = new Container("buy_course_uuid");
        $buyCourseSession->uuid = $uuid;
        $em = $this->entityManager;
        $data =  $em->getRepository(Programs::class)->findOneBy([
            "uuid" => $uuid
        ]);
        $paymentMethod = $em->getRepository(PaymentMethod::class)->findAll();

        $viewModel->setVariables([
            "data" => $data,
            "user" => $this->identity(),
            "coupon" => $coupon,
            "method" => $paymentMethod,
            "public_key" => $this->config["stripe"]["publishable_key"],
            'url' => $this->config["uurl"]
        ]);
        return $viewModel;
    }

    public function buyCourseNairaAction()
    {
        $viewModel =  new ViewModel();
        $request = $this->getRequest();
        $uuid = $this->params()->fromRoute("id", NULL);
        if ($uuid == NULL) {
            return $this->redirect()->toRoute("home");
        }
        $buyCourseSession = new Container("buy_course_uuid");
        $buyCourseSession->uuid = $uuid;
        $em = $this->entityManager;
        $data =  $em->getRepository(Programs::class)->findOneBy([
            "uuid" => $uuid
        ]);
        $paymentMethod = $em->getRepository(PaymentMethod::class)->findAll();

        $viewModel->setVariables([
            "data" => $data,
            "method" => $paymentMethod
        ]);
        return $viewModel;
    }


    public function generateInstallmentsAction()
    {
        $jsonModel = new JsonModel();
        try {
            $buyCourseSession = new Container("buy_course_uuid");

            $em = $this->entityManager;
            $user_uuid = $this->params()->fromRoute("id", NULL);
            $program_uuid = $this->params()->fromQuery("cuuid", NULL);
            if ($user_uuid == NULL || $program_uuid == NULL) {
                throw new \Exception("A required data is not avaialaible");
                $this->redirect()->toRoute("application", ["action" => "business-analysis-program"]);
            }
            $userEntity = $em->getRepository(User::class)->findOneBy([
                "uuid" => $user_uuid
            ]);
            /**
             * @var Programs
             */
            $programEntity = $em->getRepository(Programs::class)->findOneBy([
                "uuid" => $program_uuid
            ]);
            $buyCourseSession->uuid = $program_uuid;
            if ($userEntity == NULL || $programEntity == NULL) {
                throw new \Exception("A required entity is NULL");
            }

            $activeUserProgramEntity = $em->getRepository(ActiveUserProgram::class)->findOneBy([
                "user" => $userEntity->getId(),
                "program" => $programEntity->getId(),
            ]);

            if ($activeUserProgramEntity == NULL) {
                // Create new ActiveprogramEntity

                $value = $programEntity->getCost();
                $div = 4;
                $flatrate = 100;
                $amountPayable = $value + $flatrate;
                $result = array();
                $dividedValue = $amountPayable / $div; // return decimal aprimate to 2 decimal point

                // $activeUserProgramEntity->setUser($userEntity)
                //     ->setCreatedOn(new \DateTime())
                //     ->setIsInstallement(TRUE)
                //     ->setUuid((Uuid::uuid4())->toString())
                //     ->setStatus($em->find(ActiveUserProgramStatus::class, GeneralService::ACTIVE_USER_PROGRAM_STATUS_ACQUIRED))
                //     ->setProgram($programEntity)
                //     ->setIsActive(TRUE);
                for ($i = 1; $i <= $div; $i++) {
                    $installmentEntity = new Installement();

                    if ($i == 1) {
                        $result[$i] = new \DateTime();
                    } else {

                        $date = clone $result[$i - 1];
                        $addMonths = "P2W";
                        $interval = new \DateInterval($addMonths);
                        $result[$i] = $date->add($interval);
                    }

                    // $result["flatrate"][$i] = $flatrate;
                    $installmentEntity->setCreatedOn(new \DateTime())
                        ->setExpirationDate($result[$i])
                        // ->setActiveUserProgram($activeUserProgramEntity)
                        ->setUser($userEntity)
                        ->setProgram($programEntity)
                        ->setIsSettled(False)
                        ->setUuid((Uuid::uuid4())->toString())
                        ->setAmountPayable(strval($dividedValue));

                    $em->persist($installmentEntity);
                }
                // $em->persist($activeUserProgramEntity);
                $em->flush();

                $this->redirect()->toRoute("application", [
                    "action" => "installements"
                ], [
                    'query' => [
                        'cuuid' => $user_uuid,
                        "puuid" => $program_uuid
                    ],
                ]);
            } else {

                $this->redirect()->toRoute("application", [
                    "action" => "installements"
                ], [
                    'query' => [
                        'cuuid' => $user_uuid,
                        "puuid" => $program_uuid,
                    ],
                ]);
            }
        } catch (\Throwable $th) {
            print_r($th->getTraceAsString());
            $this->flashMessenger()->addErrorMessage($th->getMessage());
            // $url = $this->getRequest()->getHeader('Referer')->getUri();
            // return $this->redirect()->toUrl($url);
        }



        return $jsonModel;
    }

    public function installementsAction()
    {
        $viewModel =  new ViewModel();
        // $request = $this->getRequest();
        // $buyCourseSession = new Container("user_id");
        try {

            if ($this->identity() == NULL) {
                return $this->redirect()->toRoute("register");
            }
            $id = $this->params()->fromQuery("cuuid", NULL);
            $puuid = $this->params()->fromQuery("puuid", NULL);

            if ($id == NULL) {
                $this->redirect()->toRoute("application", ["action" => "business-analysis-program"]);
            }
            // $buyCourseSession->uuid = $uuid;
            $em = $this->entityManager;
            // $activeUserProgramEntity = $em->getRepository(ActiveUserProgram::class)->findOneBy([
            //     "uuid" => $id
            // ]);
            $userEntity = $em->getRepository(User::class)->findOneBy([
                "uuid" => $id
            ]);
            /**
             * @var Programs
             */
            $programEntity = $em->getRepository(Programs::class)->findOneBy([
                "uuid" => $puuid
            ]);
            if ($userEntity == NULL || $programEntity == NULL) {
                throw new \Exception("A required entity is NULL");
            }
            $data = $em->getRepository(Installement::class)->findBy([
                "user" => $userEntity->getId(),
                "program" => $programEntity->getId(),
            ]);

            $viewModel->setVariables([
                "data" => $data,
                "user" => $this->identity(),
                "public_key" => $this->config["stripe"]["publishable_key"],
                'url' => $this->config["uurl"]
                // "method" => $paymentMethod
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $viewModel;
    }


    public function getQuizAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $request = $this->getRequest();
        $response = $this->getResponse();
        $id = $this->params()->fromRoute("id", NULL);
        if ($id == "") {
            $jsonModel->setVariables([
                "success" => false,
                "message" => "Absent Identity"
            ]);
            $response->setStatusCode(400);
        }
        $data = $em->getRepository(Quiz::class)->createQueryBuilder("q")
            ->select(["q", "qq", "qa", "c"])
            ->leftJoin("q.course", "c")
            ->leftJoin("q.questions", "qq")
            ->leftJoin("qq.answer", "qa")

            ->where("c.id = :id")
            ->setParameters([
                "id" => $id,
            ])->getQuery()
            ->getArrayResult();

        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }





    public function careerServiceAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function careerServiceValidatorAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $em = $this->entityManager;
        if ($request->isPost()) {
            $post = $request->getPost();
            $inputFilter = new InputFilter();
            $inputFilter->add([
                'name' => 'dateStr',
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
                                'isEmpty' => 'reference data cannot be empty'
                            ]
                        ]
                    ],

                ]
            ]);
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                try {
                    $values = $inputFilter->getValues();
                    $data = $em->getRepository(ScheduleCareerTalk::class)->findOneBy([
                        "searchString" => $values["dateStr"],
                        // "isPayment" => TRUE
                    ]);
                    if ($data != NULL) {
                        throw new \Exception("Available slot has been filled, please select another date and time");
                    }
                    $response->setStatusCode(200);
                } catch (\Throwable $th) {
                    $response->setStatusCode(202);
                    $jsonModel->setVariables(["message" => $th->getMessage()]);
                }
            }
        }
        return $jsonModel;
    }

    public function careerServicePrePaymentAction()
    {
        // $viewModel = new ViewModel();
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            try {
                $post = $request->getPost();
                $data = json_decode($post["submitData"], true);
                $scheduleEntity  = new ScheduleCareerTalk();
                $uuid = (Uuid::uuid4())->toString();
                $scheduleEntity->setUuid($uuid)
                    ->setCreatedOn(new \Datetime())
                    ->setTimee($data["timee"])
                    ->setSearchString($data["searchString"])
                    ->setDateString($data["fullDateString"])
                    ->setIsPayment(FALSE)
                    ->setUser($this->identity())
                    ->setDatee($data["date"]);

                $em->persist($scheduleEntity);
                $em->flush();

                $sess  = new Container("career_service_schedule");
                $sess->uuid = $uuid;

                $jsonModel->setVariables([
                    "data" => $uuid
                ]);
                $response->setStatusCode(201);
            } catch (\Throwable $th) {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "data" => $th->getMessage()
                ]);
            }
        }
        return $jsonModel;
    }

    public function careerServicePaymentAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $request = $this->getRequest();
        $response = $this->getResponse();

        $id = $this->params()->fromRoute("id", NULL);
        try {
            if ($id == NULL) {
                throw new \Exception("Identifier absent");
            }
            $data = $em->getRepository(ScheduleCareerTalk::class)->findOneBy([
                "uuid" => $id
            ]);
            $sess  = new Container("career_service_schedule");
            $sess->uuid = $id;
            // var_dump($data);
            $viewModel->setVariables([
                "data" => $data,
                "public_key" => $this->config["stripe"]["publishable_key"],
                'url' => $this->config["uurl"]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            $viewModel->setVariables([
                "mess" => $th->getMessage()
            ]);
        }

        return $viewModel;
    }

    public function internshipAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            "data" => $data = '',
            "public_key" => $this->config["stripe"]["publishable_key"],
            'url' => $this->config["uurl"]
        ]);
        return $viewModel;
    }

    public function internshipPaymentMiddlewareAction()
    {
        $viewModel = new ViewModel();
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $auth = $this->identity();
        $em = $this->entityManager;
        $data = [];
        if ($request->isPost()) {
            $post = $request->getPost();
            try {
                if (!$this->identity()) {
                    throw new \Exception("You need to be logged in");
                }

                if ($post["cohort"] == NULL) {
                    throw new \Exception("please select a cohort");
                }

                /**
                 * @var InternshipCohort
                 */
                $cohortEntity = $em->find(InternshipCohort::class, $post["cohort"]);
                $nowDate = new \DateTime();
                if ($cohortEntity->getStartDate() < $nowDate) {

                    throw new \Exception("You cannot register to this cohort please select another date");
                }
                $sess = new Container("internship_payment");
                $sess->cohort = $cohortEntity->getId();
                $response->setStatusCode(202);
                return $jsonModel;
            } catch (\Throwable $th) {
                $jsonModel->setVariables([
                    "message" => $th->getMessage()
                ]);
                $response->setStatusCode(400);
                return $jsonModel;
            }
        }
        $viewModel->setVariables([
            "usdExchaageRate"=>$this->config["naira_per_usd"],
            "paystackPublicKey"=>$this->config["paystack"]["dev"]["public_key"],
            "email"=>$auth->getEmail(),
        ]);
        return $viewModel;
    }

    public function internshipInstallmentAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }

    public function internshipPaymentAction()
    {
        $viewModel = new ViewModel();
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $data = [];
        // if ($request->isPost()) {
        // $post = $request->getPost();
        try {
            $sess = new Container("internship_payment");
            $params = $this->params()->fromQuery("pmeth", NULL);
            if ($params == "part") {
                $sess->isPartPayment = TRUE;
            } else {
                $sess->isPartPayment = FALSE;
            }


            if (!$this->identity()) {
                throw new \Exception("You need to be logged in");
            }

            if ($sess->cohort  == NULL) {
                throw new \Exception("please select a cohort");
            }

            /**
             * @var InternshipCohort
             */
            $cohortEntity = $em->find(InternshipCohort::class, $sess->cohort);
            $nowDate = new \DateTime();
            if ($cohortEntity->getStartDate() < $nowDate) {

                throw new \Exception("You cannot register to this cohort please select another");
            }

            // $response->setStatusCode(202);
            // return $jsonModel;
        } catch (\Throwable $th) {
            $jsonModel->setVariables([
                "message" => $th->getMessage()
            ]);
            $response->setStatusCode(400);
            return $jsonModel;
        }
        // } else {
        //     $sess = new Container("internship_payment");
        //     $cohortEntity = $em->find(InternshipCohort::class, $sess->cohort);
        // }
        $viewModel->setVariables([
            "data" => $cohortEntity,
            "user" => $this->identity(),
            "public_key" => $this->config["stripe"]["publishable_key"],
            'url' => $this->config["uurl"]
        ]);
        return $viewModel;
    }


    public function getInternshipCohortAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $data = $em->getRepository(InternshipCohort::class)->createQueryBuilder("s")->select("s")->getQuery()->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }



    public function scheduleAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    // public function 

    /**
     * Get the value of entityManager
     *
     * @return  EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set the value of entityManager
     *
     * @param  EntityManager  $entityManager
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
     * @return  array
     */
    public function getConfig()
    {
        return $this->config;
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
}
