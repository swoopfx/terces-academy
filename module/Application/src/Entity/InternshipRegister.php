<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Authentication\Entity\User;
use Application\Entity\InternshipCohort;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Internship\Entity\InternshipResource;

/**
 * Undocumented class
 * @ORM\Entity
 * @ORM\Table(name="internship_register")
 */
class InternshipRegister
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
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private $user;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\InternshipCohort")
     * @var InternshipCohort
     */
    private $cohort;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime
     */
    private $updatedOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     * @var bool
     */
    private $isPayment;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     * @var bool
     */
    private $isPartialpayment;

    /**
     * Undocumented variable
     * @ORM\ManyToMany(targetEntity="Internship\Entity\InternshipResource")
     * @ORM\JoinTable(name="register_cohort_resources",
     *      joinColumns={@ORM\JoinColumn(name="register_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="resources_id", referencedColumnName="id", unique=true)}
     *      )
     * @var Collection<int, InternshipResource>
     */
    private $cohortResos;

    /**
     * Undocumented variable
     * @ORM\Column(type="date", nullable=true)
     * @var \Datetime
     */
    private $nextPaymentDate;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $nextPaymentValue;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     * @var bool
     */
    private $isFullpayment;


    public function __construct()
    {
        $this->cohortResos = new ArrayCollection();
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
     * @return  bool
     */
    public function getIsPayment()
    {
        return $this->isPayment;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isPayment  Undocumented variable
     *
     * @return  self
     */
    public function setIsPayment(bool $isPayment)
    {
        $this->isPayment = $isPayment;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  bool
     */
    public function getIsPartialpayment()
    {
        return $this->isPartialpayment;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isPartialpayment  Undocumented variable
     *
     * @return  self
     */
    public function setIsPartialpayment(bool $isPartialpayment)
    {
        $this->isPartialpayment = $isPartialpayment;

        return $this;
    }



    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getNextPaymentDate()
    {
        return $this->nextPaymentDate;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $nextPaymentDate  Undocumented variable
     *
     * @return  self
     */
    public function setNextPaymentDate(\Datetime $nextPaymentDate)
    {
        $this->nextPaymentDate = $nextPaymentDate;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getNextPaymentValue()
    {
        return $this->nextPaymentValue;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $nextPaymentValue  Undocumented variable
     *
     * @return  self
     */
    public function setNextPaymentValue(string $nextPaymentValue)
    {
        $this->nextPaymentValue = $nextPaymentValue;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  bool
     */
    public function getIsFullpayment()
    {
        return $this->isFullpayment;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isFullpayment  Undocumented variable
     *
     * @return  self
     */
    public function setIsFullpayment(bool $isFullpayment)
    {
        $this->isFullpayment = $isFullpayment;

        return $this;
    }

    /**
     * Get )
     *
     * @return  Collection
     */
    public function getCohortResos()
    {
        return $this->cohortResos;
    }


    public function addCohortResos($resos)
    {
        if (!$this->cohortResos->contains($resos)) {
            $this->cohortResos->add($resos);
        }
        return $this;
    }
}
