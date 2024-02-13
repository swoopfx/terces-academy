<?php

namespace Internship\Controller;

use Application\Entity\InternshipCohort;
use Application\Entity\InternshipRegister;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use General\Service\GeneralService;
use Internship\Entity\Assignments;
use Internship\Entity\InternshipResource;
use Laminas\View\Model\JsonModel;

class InternshipController extends AbstractActionController
{

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;

    public function dashboardAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function loginAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function assignmentsAction()
    {
        $viewModel = new ViewModel();
        try {
            $order = ($this->params()->fromQuery("order", NULL) == null ? "DESC" : "ASC");
            $pageCount = ($this->params()->fromQuery("page_count", GeneralService::MAX_PAGE_COUNT) > 100 ? 100 : $this->params()->fromQuery("page_count", GeneralService::MAX_PAGE_COUNT));
            $orderBy = $this->params()->fromQuery("order_by", "id");
            $query = $this->entityManager->createQueryBuilder()->select([
                "c", "r",
            ])->from(Assignments::class, "c")
                ->leftJoin("c.resos", "r")


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
                ->setMaxResults($pageCount)
                ->getResult(Query::HYDRATE_ARRAY);

            $viewModel->setVariables([
                "previous_page" => $previousPage,
                "next_page" => $nextPage,
                "total_page" => $totalPageCount,
                "data" => $records
            ]);
        } catch (\Throwable $th) {

            var_dump($th->getMessage());
            // $url = $this->getRequest()->getHeader('Referer')->getUri();
            // return $this->redirect()->toUrl($url);
        }
        return $viewModel;
    }

    public function getCohortAction()
    {
        $jsonModel = new JsonModel();
        $user = $this->identity();
        $em = $this->entityManager;
        $data = $em->createQueryBuilder()->select(["s", "u", "c"])
            ->from(InternshipRegister::class, "s")
            ->leftJoin("s.user", "u")
            ->leftJoin("s.cohort", "c")
            ->where("u.id = :user")
            ->setParameters([
                "user" => $user->getId()
            ])
            ->getQuery()
            ->getArrayResult();

        // var_dump($data);

        $jsonModel->setVariables([
            "data" => $data[0]["cohort"]["cohort"]
        ]);
        return $jsonModel;
    }

    public function getAssignmentSnippetAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        // $data = $em->createQueryBuilder()->select(["r", "c"])
        //     ->from(InternshipResource::class, "r")->leftJoin("r.cohort", "c")
        //     ->where()
        //     ->getQuery()->getArrayResult();
        return $jsonModel;
    }

    public function getResourcesAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $user = $this->identity();
        $registeredIntern = $em->getRepository(InternshipRegister::class)->findOneBy([
            "user" => $user->getId()
        ]);
        return $jsonModel;
    }



    public function resourcesAction()
    {
        $viewModel = new ViewModel();

        $em = $this->entityManager;
        $user = $this->identity();
        $registeredIntern = $em->getRepository(InternshipRegister::class)->findOneBy([
            "user" => $user->getId()
        ]);
        $viewModel->setVariable("resos", $registeredIntern->getCohortResos());
        return $viewModel;
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
}
