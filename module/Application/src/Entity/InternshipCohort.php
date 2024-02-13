<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Undocumented class
 * @ORM\Entity
 * @ORM\Table(name="internship_cohort")
 */
class InternshipCohort
{

    /**
     *
     * @var integer 
     * @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\Column(type="string")
     * @var string
     */
    private $cohort;

    /**
     * Undocumented variable
     * @ORM\Column(type="date", nullable=false)
     * @var \Datetime
     */
    private $startDate;


    /**
     * Get the value of id
     *
     * @return  integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */ 
    public function getCohort()
    {
        return $this->cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $cohort  Undocumented variable
     *
     * @return  self
     */ 
    public function setCohort(string $cohort)
    {
        $this->cohort = $cohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */ 
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $startDate  Undocumented variable
     *
     * @return  self
     */ 
    public function setStartDate(\Datetime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }
}
