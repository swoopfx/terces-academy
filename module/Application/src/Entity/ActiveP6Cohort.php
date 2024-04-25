<?php

namespace Application\Entity;

use Authentication\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 *  @ORM\Entity
 *  @ORM\Table(name="active_p6_cohort")
 */

class ActiveP6Cohort
{

    /**
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="P6Cohort")
     * @var P6Cohort
     */
    private P6Cohort $p6Cohort;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private User $user;

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
     * @ORM\ManyToOne(targetEntity="ActiveP6CohortStatus")
     * @var ActiveP6CohortStatus
     */
    private ActiveP6CohortStatus $status;

    /**
     * Undocumented variable
     * @ORM\OneToOne(targetEntity="ActiveUserProgram", inversedBy="oracleCohort")
     * @var ActiveUserProgram
     */
    private ActiveUserProgram $activeUserProgram;

    public function __construct()
    {
        $this->createdOn = new \DateTime();
        $this->updatedOn = new \DateTime();
    }

    /**
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
     * @return  P6Cohort
     */
    public function getP6Cohort()
    {
        return $this->p6Cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  P6Cohort  $p6Cohort  Undocumented variable
     *
     * @return  self
     */
    public function setP6Cohort(P6Cohort $p6Cohort)
    {
        $this->p6Cohort = $p6Cohort;

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
        $this->updatedOn = $createdOn;
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
     * @return  ActiveP6CohortStatus
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set undocumented variable
     *
     * @param  ActiveP6CohortStatus  $status  Undocumented variable
     *
     * @return  self
     */ 
    public function setStatus(ActiveP6CohortStatus $status)
    {
        $this->status = $status;

        return $this;
    }
}
