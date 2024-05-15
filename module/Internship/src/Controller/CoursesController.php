<?php

namespace Internship\Controller;

use Application\Entity\ActiveP6Cohort;
use Application\Entity\ActiveUserProgram;
use Application\Entity\Programs;
use Doctrine\ORM\EntityManager;
use Internship\Service\CourseService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class CoursesController extends AbstractActionController
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
     * @var CourseService
     */
    private CourseService $courseService;

    public function courseAction()
    {
        $viewModel = new ViewModel();
        $user = $this->identity();
        $data = $this->entityManager->getRepository(ActiveUserProgram::class)->createQueryBuilder("a")
            ->select(["a", "p", "u"])
            ->leftJoin("a.program", "p")
            ->leftJoin("a.user", "u")
            ->where("u.id = :userId")
            ->andWhere("a.isActive = :active")
            ->setParameters([
                "userId" => $user->getId(),
                "active" => TRUE,
            ])
            ->orderBy("a.id", "DESC")->getQuery()
            ->getResult();

        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }

    /**
     * Use this to get information about the course
     * If Student has been assigned to a cohort, then he sees all class room resources
     * else he sees not assingned to cohort
     *
     * @return void
     */
    public function infoAction()
    {
        $viewModel = new ViewModel();
        $uuid = $this->params()->fromRoute("id", NULL);
        $em = $this->entityManager;
        try {
            if ($uuid == NULL) {
                throw new \Exception("Unique Ientifier Absent");
            }

            $identity = $this->identity();
            $service  = $em->getRepository(Programs::class)->findOneBy([
                "uuid" => $uuid
            ]);
            $isAssignedToCohort = FALSE;
            $data = [];

            // get p6 room data 
            if ($service->getId() == 40) {
                // arange oracle  data 
                // get 
                $isAssignedToCohort = $em->getRepository(ActiveP6Cohort::class)->findOneBy([
                    "user" => $identity->getId(),
                ]);
                $data = $this->courseService->getP6RoomList($service->getId());
            } else if ($service->getId() == 30) {
            }
            $viewModel->setVariables([
                "isAssigned" => $isAssignedToCohort ?? FALSE,
                "data" => $data,
                "course" => $service
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            $this->flashMessenger()->addErrorMessage($th->getMessage());
            $url = $this->getRequest()->getHeader('Referer')->getUri();
            return $this->redirect()->toUrl($url);
        }
        return $viewModel;
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
     * Set undocumented variable
     *
     * @param  CourseService  $courseService  Undocumented variable
     *
     * @return  self
     */
    public function setCourseService(CourseService $courseService)
    {
        $this->courseService = $courseService;

        return $this;
    }
}
