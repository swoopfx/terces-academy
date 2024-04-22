<?php

namespace Internship\Entity;

use Application\Entity\P6Cohort;
use Doctrine\ORM\Mapping as ORM;
use General\Entity\RoomType;

class Room
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
     * @ORM\ManyToOne(targetEntity="Application\Entity\P6Cohort")
     * @var P6Cohort
     */
    private P6Cohort $p6cohort;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="General\Entity\RoomType")
     * @var RoomType
     */
    private RoomType $roomType;

    /**
     * Undocumented variable
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private string $activeDate;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", nullable=false, options={"default":0})
     * @var boolean
     */
    private bool $isLink;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private \DateTime $createdOn;

    /**
     * Undocumented variable
     *  @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private \DateTime $updatedOn;

    public function __construct()
    {
        $this->createdOn = new \DateTime();
        $this->updatedOn = new \DateTime();
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
     * @return  P6Cohort
     */
    public function getP6cohort()
    {
        return $this->p6cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  P6Cohort  $p6cohort  Undocumented variable
     *
     * @return  self
     */
    public function setP6cohort(P6Cohort $p6cohort)
    {
        $this->p6cohort = $p6cohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  RoomType
     */
    public function getRoomType()
    {
        return $this->roomType;
    }

    /**
     * Set undocumented variable
     *
     * @param  RoomType  $roomType  Undocumented variable
     *
     * @return  self
     */
    public function setRoomType(RoomType $roomType)
    {
        $this->roomType = $roomType;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getActiveDate()
    {
        return $this->activeDate;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $activeDate  Undocumented variable
     *
     * @return  self
     */
    public function setActiveDate(string $activeDate)
    {
        $this->activeDate = $activeDate;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  boolean
     */
    public function getIsLink()
    {
        return $this->isLink;
    }

    /**
     * Set undocumented variable
     *
     * @param  boolean  $isLink  Undocumented variable
     *
     * @return  self
     */
    public function setIsLink(bool $isLink)
    {
        $this->isLink = $isLink;

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
}
