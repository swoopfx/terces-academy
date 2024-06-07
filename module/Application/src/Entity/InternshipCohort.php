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
     * @ORM\Column(name="cohort", type="string")
     * @var string
     */
    private $cohortName;

    /**
     * Undocumented variable
     * @ORM\Column(type="date", nullable=false)
     * @var \Datetime
     */
    private $startDate;


    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, options={"default":1})
     * @var boolean
     */
    private bool $isActive;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", options={"default":0})
     * @var bool
     */
    private bool $presentlyActive;

    /**
     * Undocumented variable
     *  @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private \DateTime $createdOn;


    public function __construct()
    {
        $this->presentlyActive = false;
    }

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
        return $this->cohortName;
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
        $this->cohortName = $cohort;

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

    /**
     * Get undocumented variable
     *
     * @return  bool
     */
    public function getPresentlyActive()
    {
        return $this->presentlyActive;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $presentlyActive  Undocumented variable
     *
     * @return  self
     */
    public function setPresentlyActive(bool $presentlyActive)
    {
        $this->presentlyActive = $presentlyActive;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set undocumented variable
     *
     * @param  boolean  $isActive  Undocumented variable
     *
     * @return  self
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  \DateTime  $createdOn  Undocumented variable
     *
     * @return  self
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getCohortName()
    {
        return $this->cohortName;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $cohortName  Undocumented variable
     *
     * @return  self
     */
    public function setCohortName(string $cohortName)
    {
        $this->cohortName = $cohortName;

        return $this;
    }
}
