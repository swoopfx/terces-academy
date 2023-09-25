<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Authentication\Entity\User;
use Application\Entity\Programs;

/**
 * Undocumented class
 * @ORM\Entity
 * @ORM\Table(name="interac_payment")
 */
class InteracPayment
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
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private $user;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $amount;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $interacEmail;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\Programs")
     * @var Programs
     */
    private $program;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, options={"default":0}, type="boolean")
     * @var bool
     */
    private $isConfirmed = 0;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, options={"default":0}, type="boolean")
     * @var bool
     */
    private $isFailed = 0;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, options={"default":0}, type="boolean")
     * @var bool
     */
    private $isProcessed = 0;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=true)
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=true)
     * @var \Datetime
     */
    private $updatedOn;

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
     * @return  bool
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isConfirmed  Undocumented variable
     *
     * @return  self
     */
    public function setIsConfirmed(bool $isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  bool
     */
    public function getIsFailed()
    {
        return $this->isFailed;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isFailed  Undocumented variable
     *
     * @return  self
     */
    public function setIsFailed(bool $isFailed)
    {
        $this->isFailed = $isFailed;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  bool
     */
    public function getIsProcessed()
    {
        return $this->isProcessed;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isProcessed  Undocumented variable
     *
     * @return  self
     */
    public function setIsProcessed(bool $isProcessed)
    {
        $this->isProcessed = $isProcessed;

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
    public function getInteracEmail()
    {
        return $this->interacEmail;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $interacEmail  Undocumented variable
     *
     * @return  self
     */
    public function setInteracEmail(string $interacEmail)
    {
        $this->interacEmail = $interacEmail;

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
}
