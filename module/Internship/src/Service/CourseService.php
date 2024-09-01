<?php

namespace Internship\Service;

use Doctrine\ORM\EntityManager;
use Internship\Entity\P6Room;

class CourseService
{

    private EntityManager $entityManager;


    public function getP6RoomList($cohortId)
    {
        $em = $this->entityManager;
        $data = $em->getRepository(P6Room::class)
            ->createQueryBuilder("r")
            ->select("r.id, r.activeDate, r.isLink, rt.id as roomtypeId, rt.type as roomType, cohort")
            ->innerJoin("r.roomType", "rt")
            ->innerJoin("r.p6cohort", "cohort")->where("cohort.id = :cohort")
            ->setParameters([
                "cohort" => $cohortId
            ])->groupBy("rt")->getQuery()
            ->getResult();
        return $data;
    }


    public function getActiveZoomForP6() {
        
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
}
