<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\ActiveUserProgram;
use Application\Entity\ActiveUserProgramStatus;
use Application\Entity\CourseContent;
use Application\Entity\Courses;
use Application\Entity\Installement;
use Application\Entity\PaymentMethod;
use Application\Entity\Programs;
use Application\Entity\Quiz;
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

class IndexController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    private $entityManager;

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
                $flatrate = 200;
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
                "data" => $data
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
}
