<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\Programs;
use Application\Entity\TransactionStatus;
use Authentication\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="transaction")
 */

class Transaction
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
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $transactionId;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, type="datetime")
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, type="datetime")
     * @var \Datetime
     */
    private $updatedOn;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Programs")
     */
    private $program;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\TransactionStatus")
     * @var TransactionStatus
     */
    private $status;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $flutterWaveRef;

    /**
     * Undocumented variable
     *  @ORM\Column(nullable=true)
     * @var string
     */
    private $flutterWaveId;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $amount;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", nullable=false, options={"default":"1"})
     * @var bool
     */
    private $isActive;


    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var  string
     */
    private $paypalId;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $paypalOrderId;

    /**
     * Contains json encoded data of a confimation information 
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $paypalConfirmData;

    /**
     * Undocumented variable
     * @ORM\ManytoOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private $user;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $paystackData;


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
     * @return  string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $transactionId  Undocumented variable
     *
     * @return  self
     */
    public function setTransactionId(string $transactionId)
    {
        $this->transactionId = $transactionId;

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
     * Get the value of program
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Set the value of program
     *
     * @return  self
     */
    public function setProgram($program)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  TransactionStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set undocumented variable
     *
     * @param  TransactionStatus  $status  Undocumented variable
     *
     * @return  self
     */
    public function setStatus(TransactionStatus $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getFlutterWaveRef()
    {
        return $this->flutterWaveRef;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $flutterWaveRef  Undocumented variable
     *
     * @return  self
     */
    public function setFlutterWaveRef(string $flutterWaveRef)
    {
        $this->flutterWaveRef = $flutterWaveRef;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getFlutterWaveId()
    {
        return $this->flutterWaveId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $flutterWaveId  Undocumented variable
     *
     * @return  self
     */
    public function setFlutterWaveId(string $flutterWaveId)
    {
        $this->flutterWaveId = $flutterWaveId;

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
     * @return  string
     */
    public function getPaypalId()
    {
        return $this->paypalId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $paypalId  Undocumented variable
     *
     * @return  self
     */
    public function setPaypalId(string $paypalId)
    {
        $this->paypalId = $paypalId;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getPaypalOrderId()
    {
        return $this->paypalOrderId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $paypalOrderId  Undocumented variable
     *
     * @return  self
     */
    public function setPaypalOrderId(string $paypalOrderId)
    {
        $this->paypalOrderId = $paypalOrderId;

        return $this;
    }

    /**
     * Get contains json encoded data of a confimation information
     *
     * @return  string
     */
    public function getPaypalConfirmData()
    {
        return $this->paypalConfirmData;
    }

    /**
     * Set contains json encoded data of a confimation information
     *
     * @param  string  $paypalConfirmData  Contains json encoded data of a confimation information
     *
     * @return  self
     */
    public function setPaypalConfirmData(string $paypalConfirmData)
    {
        $this->paypalConfirmData = $paypalConfirmData;

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
     * @return  string
     */
    public function getPaystackData()
    {
        return $this->paystackData;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $paystackData  Undocumented variable
     *
     * @return  self
     */
    public function setPaystackData(string $paystackData)
    {
        $this->paystackData = $paystackData;

        return $this;
    }
}
