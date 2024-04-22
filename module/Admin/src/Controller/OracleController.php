<?php

namespace Admin\Controller;

use Application\Entity\ActiveUserProgram;
use Application\Entity\P6Cohort;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;

class OracleController extends AbstractActionController
{

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private EntityManager $entityManager;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->layout()->setTemplate("admin-layout");
    }

    public function registeredUsersAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $data = $em->getRepository(ActiveUserProgram::class)
            ->createQueryBuilder("a")
            ->select(["a", "u"])
            ->innerJoin("a.user", "u")
            ->where("a.program = :program")
            ->andWhere("a.isActive = :active")
            ->setParameters([
                "active" => TRUE,
                "program" => 40
            ])->getQuery()->getArrayResult();
        $viewModel->setVariables([
            "data" => $data
        ]);
        return $viewModel;
    }

    public function viewAction()
    {
        $viewModel = new ViewModel();
        $uuid = $this->params()->fromRoute("id", NULL);
        try {
            if ($uuid == NULL) {
                throw new \Exception("No Identifier");
            }
            $em = $this->entityManager;
            // $data = $em->getRepository(ActiveUserProgram::class)->findOneBy([
            //     "uuid" => $uuid
            // ]);
            $data = $em->getRepository(ActiveUserProgram::class)
                ->createQueryBuilder("a")
                ->select(["a", "p", "u", "s",  "oraclech"])
                ->leftJoin("a.user", "u")
                ->leftJoin("a.program", "p")
                ->leftJoin("a.oracleCohort", "oraclech")
                ->leftJoin("a.status", "s")
                // ->leftJoin("a.paidInstallment", "paidInstallement")
                ->where("a.uuid = :uuid")
                ->andWhere("a.isActive = :active")
                ->setParameters([
                    "active" => TRUE,
                    "uuid" => $uuid
                ])->getQuery()->getArrayResult();

            $viewModel->setVariables([
                "data" => $data[0]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            var_dump($th->getMessage());
            // $this->flashMessenger()->addErrorMessage($th->getMessage());
            // $url = $this->getRequest()->getHeader('Referer')->getUri();
            // return $this->redirect()->toUrl($url);
        }

        return $viewModel;
    }

    public function createCohortAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function getCohortAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $data = $em->getRepository(P6Cohort::class)->createQueryBuilder("c")
            ->select(["c"])
            ->where("c.isActive = :active")
            ->setParameters([
                "active" => TRUE
            ])->setMaxResults(10)->getQuery()->getArrayResult();
        $viewModel->setVariables([
            "data" => $data
        ]);
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
}
