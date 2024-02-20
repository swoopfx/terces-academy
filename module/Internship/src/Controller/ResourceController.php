<?php

namespace  Internship\Controller;

use Admin\Entity\ZoomVideo;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ResourceController extends AbstractActionController
{

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private EntityManager $entityManager;

    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function videoAction()
    {
        $viewModel = new ViewModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $data = $em->getRepository(ZoomVideo::class)
            ->createQueryBuilder("z")
            ->select(["z", "z.id", "z.titles", "z.descs", "z.createdOn", "v.imageUrl",  "v", "c.cohort", "z.isActive", "z.uuid"])
            ->leftJoin("z.cohort", "c")
            ->leftJoin("z.video", "v")
            ->where("z.isActive = :active")->setParameters([
                "active" => TRUE
            ])->getQuery()->getResult();
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
