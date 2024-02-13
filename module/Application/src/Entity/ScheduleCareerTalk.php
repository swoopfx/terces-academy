<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Authentication\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="schedule_career_talk")
 */

class ScheduleCareerTalk
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
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $uuid;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private $user;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var \Datetime
     */
    private $datee;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $timee;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $searchString;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $dateString;

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
     * @return  string
     */
    public function getDateString()
    {
        return $this->dateString;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $dateString  Undocumented variable
     *
     * @return  self
     */
    public function setDateString(string $dateString)
    {
        $this->dateString = $dateString;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getTimee()
    {
        return $this->timee;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $timee  Undocumented variable
     *
     * @return  self
     */
    public function setTimee(string $timee)
    {
        $this->timee = $timee;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getDatee()
    {
        return $this->datee;
    }

    /**
     * Set undocumented variable
     *
     * @param  string $datee  Undocumented variable
     *
     * @return  self
     */
    public function setDatee($datee)
    {
        $this->datee = $datee;

        return $this;
    }

    /**
     * Get the value of user
     *
     * @return  User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @param  User  $user
     *
     * @return  self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

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
     * @return  string
     */
    public function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $searchString  Undocumented variable
     *
     * @return  self
     */
    public function setSearchString(string $searchString)
    {
        $this->searchString = $searchString;

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
}
