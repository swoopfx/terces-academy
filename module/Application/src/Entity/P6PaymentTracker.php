<?php

namespace Application\Entity;

use Authentication\Entity\User;
use Doctrine\Orm\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="p6_payment_tracker")
 */
class P6PaymentTracker
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
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private User $user;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="P6Cohort")
     * @var P6Cohort
     */
    private P6Cohort $cohort;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="ActiveUserProgram")
     * @var ActiveUserProgram
     */
    private ActiveUserProgram $userProgram;

    /**
     * Undocumented variable
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private string $amount;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private \DateTime $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private \DateTime $updatedOn;

    /**
     * Undocumented variable
     * @ORM\Manytoone(targetEntity="Transaction")
     * @var Transaction
     */
    private Transaction $transaction;

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
     * @return  P6Cohort
     */
    public function getCohort()
    {
        return $this->cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  P6Cohort  $cohort  Undocumented variable
     *
     * @return  self
     */
    public function setCohort(P6Cohort $cohort)
    {
        $this->cohort = $cohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $amount  Undocumented variable
     *
     * @return  self
     */
    public function setAmount(string $amount)
    {
        $this->amount = $amount;

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
     * @return  Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set undocumented variable
     *
     * @param  Transaction  $transaction  Undocumented variable
     *
     * @return  self
     */
    public function setTransaction(Transaction $transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  ActiveUserProgram
     */ 
    public function getUserProgram()
    {
        return $this->userProgram;
    }

    /**
     * Set undocumented variable
     *
     * @param  ActiveUserProgram  $userProgram  Undocumented variable
     *
     * @return  self
     */ 
    public function setUserProgram(ActiveUserProgram $userProgram)
    {
        $this->userProgram = $userProgram;

        return $this;
    }
}
