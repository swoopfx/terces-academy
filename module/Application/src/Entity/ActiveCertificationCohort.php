<?php

namespace Application\Entity;

use Authentication\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="active_certification")
 */
class ActiveCertificationCohort
{

    /**
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="CertificationsCohort")
     * @var CertificationsCohort
     */
    private CertificationsCohort $cohort;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, options={"default":1})
     * @var boolean
     */
    private bool  $isActive;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private \DateTime $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private \DateTime $updatedOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @var string
     */
    private string $uuid;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="ActiveCertificationStatus")
     * @var ActiveCertificationStatus
     */
    private ActiveCertificationStatus $status;


    /**
     * Undocumented variable
     * @ORM\OneToOne(targetEntity="ActiveUserProgram", inversedBy="certificationCohort")
     * @var ActiveUserProgram
     */
    private ActiveUserProgram $activeUserProgram;

    /**
     * Get @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get undocumented variable
     *
     * @return  CertificationsCohort
     */
    public function getCohort()
    {
        return $this->cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  CertificationsCohort  $cohort  Undocumented variable
     *
     * @return  self
     */
    public function setCohort(CertificationsCohort $cohort)
    {
        $this->cohort = $cohort;

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
     * @return  \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  \DateTime  $updatedOn  Undocumented variable
     *
     * @return  self
     */
    public function setUpdatedOn(\DateTime $updatedOn)
    {
        $this->updatedOn = $updatedOn;

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

    /**
     * Get undocumented variable
     *
     * @return  ActiveUserProgram
     */
    public function getActiveUserProgram()
    {
        return $this->activeUserProgram;
    }

    /**
     * Set undocumented variable
     *
     * @param  ActiveUserProgram  $activeUserProgram  Undocumented variable
     *
     * @return  self
     */
    public function setActiveUserProgram(ActiveUserProgram $activeUserProgram)
    {
        $this->activeUserProgram = $activeUserProgram;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  ActiveCertificationStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set undocumented variable
     *
     * @param  ActiveCertificationStatus  $status  Undocumented variable
     *
     * @return  self
     */
    public function setStatus(ActiveCertificationStatus $status)
    {
        $this->status = $status;

        return $this;
    }
}
