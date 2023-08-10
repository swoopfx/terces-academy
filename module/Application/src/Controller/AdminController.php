<?php

namespace Application\Controller;

use Application\Entity\ActiveUserProgram;
use Laminas\Mvc\Controller\AbstractActionController;
use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Laminas\View\Model\ViewModel;

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

    // private $

    public function indexAction()
    {
    }

    public function activeCustomerListAction()
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
                // "partial s.{id, status}",
                // "partial wt.{id, type}",
                // "partial wu.{id, fullname, username, email}"
            ])->from(ActiveUserProgram::class, "c")
                ->leftJoin("c.user", "u")
                ->leftJoin("c.program", "p")

                ->where("c.user = :userId")
                ->andWhere("c.isActive = :active")


                ->setParameters([
                    "userId" => $userEntity->getId(),
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

    public function customerDetailsAction()
    {
        $id = $this->params()->fromRoute("id", NULL);
        if ($id == NULL) {
            return $this->redirect()->toRoute();
        }
    }

    public function trainingListAction()
    {
    }

    public function viewTrainingAction()
    {
    }

    public function addCourseAction()
    {
    }

    public function editCourseAction()
    {
    }

    public function removeCourseAction()
    {
    }

    public function addCourseVideoAction()
    {
    }

    public function editCourseVideoAction()
    {
    }

    public function removeCourseVideoAction()
    {
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
}
