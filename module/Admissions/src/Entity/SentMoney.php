<?php

namespace Admissions\Entity;

use Doctrine\ORM\Mapping as ORM;
use Admissions\Entity\CanadianBanks;
use Authentication\Entity\User;
use Admissions\Entity\SendMoneyService;
use Admissions\Entity\SendMoneyStatus;

/**
 * Undocumented class
 * @ORM\Entity
 * @ORM\Table(name="sent_money")
 */
class  SentMoney
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
    private $user;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $recipientFullname;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Admissions\Entity\SendMoneyService")
     * @var SendMoneyService
     */
    private $recipientService;

    /**
     * Undocumented variable
     * @ORM\Column(nullable = true)
     * @var string
     */
    private $recipientInteracEmail;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Admissions\Entity\CanadianBanks")
     * @var CanadianBanks
     */
    private $canadianBank;

    /**
     * Undocumented variable
     * @ORM\Column(name="account_number", nullable=true)
     * @var string
     */
    private $accountNumber;

    /**
     * Undocumented variable
     * @ORM\ManyToMany(targetEntity="Admissions\Entity\SendMoneyStatus")
     * @var SendMoneyStatus
     */
    private $status;

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
     * @return  string
     */
    public function getRecipientFullname()
    {
        return $this->recipientFullname;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $recipientFullname  Undocumented variable
     *
     * @return  self
     */
    public function setRecipientFullname(string $recipientFullname)
    {
        $this->recipientFullname = $recipientFullname;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  SendMoneyService
     */
    public function getRecipientService()
    {
        return $this->recipientService;
    }

    /**
     * Set undocumented variable
     *
     * @param  SendMoneyService  $recipientService  Undocumented variable
     *
     * @return  self
     */
    public function setRecipientService(SendMoneyService $recipientService)
    {
        $this->recipientService = $recipientService;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getRecipientInteracEmail()
    {
        return $this->recipientInteracEmail;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $recipientInteracEmail  Undocumented variable
     *
     * @return  self
     */
    public function setRecipientInteracEmail(string $recipientInteracEmail)
    {
        $this->recipientInteracEmail = $recipientInteracEmail;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  CanadianBanks
     */
    public function getCanadianBank()
    {
        return $this->canadianBank;
    }

    /**
     * Set undocumented variable
     *
     * @param  CanadianBanks  $canadianBank  Undocumented variable
     *
     * @return  self
     */
    public function setCanadianBank(CanadianBanks $canadianBank)
    {
        $this->canadianBank = $canadianBank;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $accountNumber  Undocumented variable
     *
     * @return  self
     */
    public function setAccountNumber(string $accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  SendMoneyStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set undocumented variable
     *
     * @param  SendMoneyStatus  $status  Undocumented variable
     *
     * @return  self
     */
    public function setStatus(SendMoneyStatus $status)
    {
        $this->status = $status;

        return $this;
    }
}
