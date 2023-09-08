<?php

namespace Application\Entity;

use Authentication\Entity\User;
use Application\Entity\ActiveUserProgram;
use Application\Entity\Programs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="installment")
 */

class Installement
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
     * @ORM\Column(unique=true)
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $amountPayable;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
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
     * @ORM\Column(type="datetime")
     * @var \Datetime
     */
    private $expirationDate;

    /**
     * if the payments is settled
     * @ORM\Column(type="boolean", options={"default":0})
     * @var bool
     */
    private $isSettled;


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
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\ActiveUserProgram", inversedBy="activeInstallment")
     * @var ActiveUserProgram
     */
    private $activeUserProgram;

    /**
     * Get 
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    // /**
    //  * Get undocumented variable
    //  *
    //  * @return  User
    //  */
    // public function getUser()
    // {
    //     return $this->user;
    // }

    // /**
    //  * Set undocumented variable
    //  *
    //  * @param  User  $user  Undocumented variable
    //  *
    //  * @return  self
    //  */
    // public function setUser(User $user)
    // {
    //     $this->user = $user;

    //     return $this;
    // }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $expirationDate  Undocumented variable
     *
     * @return  self
     */
    public function setExpirationDate(\Datetime $expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get if the payments is settled
     *
     * @return  bool
     */
    public function getIsSettled()
    {
        return $this->isSettled;
    }

    /**
     * Set if the payments is settled
     *
     * @param  bool  $isSettled  if the payments is settled
     *
     * @return  self
     */
    public function setIsSettled(bool $isSettled)
    {
        $this->isSettled = $isSettled;

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

    // /**
    //  * Get undocumented variable
    //  *
    //  * @return  ActiveUserProgram
    //  */
    // public function getActiveUserProgram()
    // {
    //     return $this->activeUserProgram;
    // }

    // /**
    //  * Set undocumented variable
    //  *
    //  * @param  ActiveUserProgram  $activeUserProgram  Undocumented variable
    //  *
    //  * @return  self
    //  */
    // public function setActiveUserProgram(ActiveUserProgram $activeUserProgram)
    // {
    //     $this->activeUserProgram = $activeUserProgram;

    //     return $this;
    // }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getAmountPayable()
    {
        return $this->amountPayable;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $amountPayable  Undocumented variable
     *
     * @return  self
     */
    public function setAmountPayable(string $amountPayable)
    {
        $this->amountPayable = $amountPayable;

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
}
