<?php

namespace Admin\Controller;

use Application\Entity\ActiveBusinessAnalysisCohort;
use Application\Entity\ActiveUserProgram;
use Application\Entity\InternshipCohort;
use Application\Entity\Programs;
use Authentication\Entity\User;
use Doctrine\ORM\EntityManager;
use General\Service\UploadService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Ramsey\Uuid\Uuid;

class ZoomController extends AbstractActionController
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

    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function uploadVideosAction()
    {
        // $view
    }

    public function assignUserToBaCohortAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $cSeed = new Container("process_seed");
        $em = $this->entityManager;

        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            try {
                if ($post["seed"] != $cSeed->seed) {
                    throw new \Exception("Invalid Seed");
                }

                // $allActiveUserProgram = $em->getRepository(ActiveUserProgram::class)->findBy([
                //     "program" => $post["program"]
                // ]);

                $activeUserProgram = $em->getRepository(ActiveUserProgram::class)->findOneBy([
                    "program"=>$post["program"],
                    "user"=>$post["user"]
                ]);


                $activeCohortEntity = InternshipCohort::class;

                $activeBusinessMassterClassCohortEntity = new ActiveBusinessAnalysisCohort();
                $activeBusinessMassterClassCohortEntity->setCreatedOn(new \Datetime())
                    ->setCohort($em->find($activeCohortEntity, $post["cohort"]))->setIsActive(TRUE)
                    ->setProgram($em->find(Programs::class, $post["program"]))
                    ->setUuid(Uuid::uuid4()->toString())->setUser($em->find(User::class, $post["user"]));

                $em->persist($activeBusinessMassterClassCohortEntity);
                $em->flush();

                // trigger notification to all registered user 

                $response->setStatusCode(201);
                $jsonModel->setVariables([
                    "success" => TRUE
                ]);
            } catch (\Throwable $th) {
                $response->setStatusCode(423);
                $jsonModel->setVariables([
                    "message" => $th->getMessage()
                ]);
            }
        }
        return $jsonModel;
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
