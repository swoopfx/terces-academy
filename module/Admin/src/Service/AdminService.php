<?php

namespace Admin\Service;

use Application\Entity\ActiveP6Cohort;
use Application\Entity\ActiveP6CohortStatus;
use Application\Entity\ActiveUserProgram;
use Application\Entity\ActiveUserProgramStatus;
use Application\Entity\P6Cohort;
use Doctrine\ORM\EntityManager;
use General\Service\PostMarkService;
use Postmark\Models\PostmarkServer;
use Ramsey\Uuid\Uuid;

class AdminService
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
     * @var PostMarkService
     */
    private PostMarkService $postmarkService;


    private function interacPaymentMade(){
        
    }

    /**
     * Undocumented function
     *
     * @param array|null $dat
     * @return array
     */
    private function paymentMade(?array $dat): array
    {
        $data = [];
        return $data;
    }

    private function assignToOracleCohort(?array $dat): array
    {
        $data = [];
        $em = $this->entityManager;
        $activeUserProgramEntity = $em->find(ActiveUserProgram::class, $dat["activeUserProgram"]);
        $cohortEntity = $em->find(P6Cohort::class, $dat["cohort"]);
        $activeUserProgramEntity->setStatus($em->find(ActiveUserProgramStatus::class, 150))->setUpdatedOn(new \Datetime());
        $activeP6OracleEntity = new ActiveP6Cohort();
        $activeP6OracleEntity->setCreatedOn(new \Datetime())
            ->setUser($activeUserProgramEntity->getUser())
            ->setUuid(Uuid::uuid4()->toString())
            ->setIsActive(TRUE)
            ->setStatus($em->find(ActiveP6CohortStatus::class, 10))
            ->setP6Cohort($cohortEntity)
            ->setActiveUserProgram($activeUserProgramEntity);

        $em->persist($activeUserProgramEntity);
        $em->persist($activeP6OracleEntity);
        $em->flush();

        $mailData["to"] = $activeUserProgramEntity->getUser()->getEmail();
        $mailData["name"] = $activeUserProgramEntity->getUser()->getFullname();
        $mailData["cohort"] = $cohortEntity->getCohortName();
        $mailData["program"] = $activeUserProgramEntity->getProgram()->getTitle();
        $this->postmarkService->assignedUserToCohort($mailData);
        return $data;
    }


    /**
     * Set the value of entityManager
     *
     * @return  self
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Set undocumented variable
     *
     * @param  PostMarkService  $postmarkService  Undocumented variable
     *
     * @return  self
     */ 
    public function setPostmarkService(PostMarkService $postmarkService)
    {
        $this->postmarkService = $postmarkService;

        return $this;
    }
}
