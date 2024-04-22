<?php

namespace Internship\Controller;

use Application\Entity\ActiveUserProgram;
use Doctrine\ORM\EntityManager;
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

    public function infoAction()
    {
        $viewModel = new ViewModel();
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
