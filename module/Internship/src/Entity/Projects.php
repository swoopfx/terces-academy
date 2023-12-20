<?php

namespace Internship\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\InternshipCohort;

/**
 * @ORM\Entity
 * @ORM\Table(name="projects")
 */
class Projects
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $projectName;

    /**
     * Undocumented variable
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $projectDesc;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\InternshipCohort")
     * @var InternshipCohort
     */
    private $cohort;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=true)
     * @var \Datetime
     */
    private $createdOn;




    /**
     * Get @ORM\Column(name="id", type="integer")
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
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $projectName  Undocumented variable
     *
     * @return  self
     */
    public function setProjectName(string $projectName)
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getProjectDesc()
    {
        return $this->projectDesc;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $projectDesc  Undocumented variable
     *
     * @return  self
     */
    public function setProjectDesc(string $projectDesc)
    {
        $this->projectDesc = $projectDesc;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  InternshipCohort
     */
    public function getCohort()
    {
        return $this->cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  InternshipCohort  $cohort  Undocumented variable
     *
     * @return  self
     */
    public function setCohort(InternshipCohort $cohort)
    {
        $this->cohort = $cohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $createdOn  Undocumented variable
     *
     * @return  self
     */
    public function setCreatedOn(\Datetime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $uuid  Undocumented variable
     *
     * @return  self
     */
    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }
}
