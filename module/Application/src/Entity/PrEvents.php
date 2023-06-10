<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This sets the event
 * and alos put the free event at postion 100 
 * @ORM\Entity
 * @ORM\Table(name="pr_events")
 */
class PrEvents
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    // private 

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $eventname;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="text")
     * @var string
     */
    private $eventDescription;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="datetime")
     * @var \Datetime
     */
    private $dateTimeBegin;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="datetime")
     * @var \Datetime
     */
    private $dateTimeEnd;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="boolean")
     * @var bool
     */
    private $isActive;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="datetime")
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="datetime")
     * @var \Datetime
     */
    private $updatedOn;

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
    public function getEventname()
    {
        return $this->eventname;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $eventname  Undocumented variable
     *
     * @return  self
     */
    public function setEventname(string $eventname)
    {
        $this->eventname = $eventname;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getEventDescription()
    {
        return $this->eventDescription;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $eventDescription  Undocumented variable
     *
     * @return  self
     */
    public function setEventDescription(string $eventDescription)
    {
        $this->eventDescription = $eventDescription;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getDateTimeBegin()
    {
        return $this->dateTimeBegin;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $dateTimeBegin  Undocumented variable
     *
     * @return  self
     */
    public function setDateTimeBegin(\Datetime $dateTimeBegin)
    {
        $this->dateTimeBegin = $dateTimeBegin;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getDateTimeEnd()
    {
        return $this->dateTimeEnd;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $dateTimeEnd  Undocumented variable
     *
     * @return  self
     */
    public function setDateTimeEnd(\Datetime $dateTimeEnd)
    {
        $this->dateTimeEnd = $dateTimeEnd;

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
}
