<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Authentication\Entity\User;
use Application\Entity\Installement;
use Application\Entity\Programs;
use Application\Entity\ActiveUserProgramStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * These are the users registtered to a program 
 * @ORM\Entity
 * @ORM\Table(name="active_user_program")
 */

class ActiveUserProgram
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * Undocumented variable
     * @ORM\ManytoOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private $user;


    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\Programs")
     * @var Programs
     */
    private $program;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", nullable=false, options={"default":"1"})
     * @var bool
     */
    private $isActive;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \Datetime
     */
    private $updatedOn;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\ActiveUserProgramStatus")
     * @var ActiveUserProgramStatus
     */
    private $status;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", options={"default":0})
     * @var bool
     */
    private $isInstallement;

    /**
     * Undocumented variable
     * @ORM\OneToMany(targetEntity="Application\Entity\Installement", mappedBy="activeUserProgram")
     * @var Collection
     */
    private $activeInstallment;

    /**
     * Undocumented variable
     * ManyToOne(targetEntity="Application\Entity\Installement")
     * @var Installement
     */
    private $paidInstallment;


    /**
     * Undocumented variable
     * @ORM\OneToOne(targetEntity="ActiveP6Cohort", mappedBy="activeUserProgram")
     * @var ActiveP6Cohort
     */
    private ActiveP6Cohort  $oracleCohort;


    public function __construct()
    {
        $this->activeInstallment = new ArrayCollection();
    }


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
     * @return  User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set undocumented variable
     *
     * @param  User  $user  Undocumented variable
     *
     * @return  self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Programs
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Set undocumented variable
     *
     * @param  Programs  $program  Undocumented variable
     *
     * @return  self
     */
    public function setProgram(Programs $program)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isActive  Undocumented variable
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
        $this->updatedOn = $createdOn;
        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $updatedOn  Undocumented variable
     *
     * @return  self
     */
    public function setUpdatedOn(\Datetime $updatedOn)
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
     * @return  ActiveUserProgramStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set undocumented variable
     *
     * @param  ActiveUserProgramStatus  $status  Undocumented variable
     *
     * @return  self
     */
    public function setStatus(ActiveUserProgramStatus $status)
    {
        $this->status = $status;

        return $this;
    }



    /**
     * Set undocumented variable
     *
     * @param  Installement  $activeInstallment  Undocumented variable
     *
     * @return  self
     */
    public function setActiveInstallment(Installement $activeInstallment)
    {
        $this->activeInstallment = $activeInstallment;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  bool
     */
    public function getIsInstallement()
    {
        return $this->isInstallement;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isInstallement  Undocumented variable
     *
     * @return  self
     */
    public function setIsInstallement(bool $isInstallement)
    {
        $this->isInstallement = $isInstallement;

        return $this;
    }

    /**
     * Get manyToOne(targetEntity="Application\Entity\Installement")
     *
     * @return  Installement
     */
    public function getPaidInstallment()
    {
        return $this->paidInstallment;
    }

    /**
     * 
     *
     * @param  Installement  $paidInstallment  ManyToOne(targetEntity="Application\Entity\Installement")
     *
     * @return  self
     */
    public function setPaidInstallment(Installement $paidInstallment)
    {
        $this->paidInstallment = $paidInstallment;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Collection
     */
    public function getActiveInstallment()
    {
        return $this->activeInstallment;
    }

    /**
     * Get undocumented variable
     *
     * @return  ActiveP6Cohort
     */ 
    public function getOracleCohort()
    {
        return $this->oracleCohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  ActiveP6Cohort  $oracleCohort  Undocumented variable
     *
     * @return  self
     */ 
    public function setOracleCohort(ActiveP6Cohort $oracleCohort)
    {
        $this->oracleCohort = $oracleCohort;

        return $this;
    }
}
