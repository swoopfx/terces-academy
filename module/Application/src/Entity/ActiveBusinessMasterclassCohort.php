<?php

namespace Application\Entity;

use Authentication\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="active_business_class_cohort")
 */

class ActiveBusinessMasterclassCohort
{

    /**
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private User $user;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="MasterClassCohort")
     * @var MasterClassCohort
     */
    private MasterClassCohort $cohort;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="ActiveBusinessMasterclassCohortStatus")
     * @var ActiveBusinessMasterclassCohortStatus
     */
    private ActiveBusinessMasterclassCohortStatus $status;

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
     * @ORM\OneToOne(targetEntity="ActiveUserProgram", inversedBy="masterClassCohort")
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
     * @return  MasterClassCohort
     */
    public function getCohort()
    {
        return $this->cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  MasterClassCohort  $cohort  Undocumented variable
     *
     * @return  self
     */
    public function setCohort(MasterClassCohort $cohort)
    {
        $this->cohort = $cohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  ActiveBusinessMasterclassCohortStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set undocumented variable
     *
     * @param  ActiveBusinessMasterclassCohortStatus  $status  Undocumented variable
     *
     * @return  self
     */
    public function setStatus(ActiveBusinessMasterclassCohortStatus $status)
    {
        $this->status = $status;

        return $this;
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
}
