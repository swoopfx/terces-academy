<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\PaymentMethod;
use Application\Entity\Programs;
use Application\Entity\Quiz;
use Doctrine\ORM\EntityManager;
use Laminas\Db\Sql\Where;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

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
