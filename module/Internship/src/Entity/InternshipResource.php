<?php

namespace Internship\Entity;

use Doctrine\ORM\Mapping as ORM;
use General\Entity\Image;
use Application\Entity\InternshipCohort;
use Application\Entity\MasterClassCohort;
use General\Entity\RoomType;

/**
 * @ORM\Entity
 * @ORM\Table(name="internship_resources")
 */
class InternshipResource
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
     * @ORM\Column(nullable=false, name="title")
     * @var string
     */
    private $title;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\InternshipCohort")
     * @var InternshipCohort
     */
    private InternshipCohort $cohort;

    /**
     * Master Class Cohort
     * @ORM\ManyToOne(targetEntity="Application\Entity\MasterClassCohort")
     * @var MasterClassCohort
     */
    private MasterClassCohort $masterClassCohort;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $uuid;


    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="General\Entity\Image")
     * @var Image
     */
    private $resos;

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
     *Defines if the resos is for every general use and not restricted by cohort
     * @ORM\Column(type="boolean", nullable=false, options={"default":0})
     * @var boolean
     */
    private bool $isGeneral;

    /**
     *  defines the speific type of room the resos is meant for
     * @ORM\ManyToOne(targetEntity="General\Entity\RoomType")
     * @var RoomType
     */
    private RoomType  $roomType;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $title  Undocumented variable
     *
     * @return  self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

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
     * @return  Image
     */
    public function getResos()
    {
        return $this->resos;
    }

    /**
     * Set undocumented variable
     *
     * @param  Image  $resos  Undocumented variable
     *
     * @return  self
     */
    public function setResos(Image $resos)
    {
        $this->resos = $resos;

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
     * Get master Class Cohort
     *
     * @return  MasterClassCohort
     */
    public function getMasterClassCohort()
    {
        return $this->masterClassCohort;
    }

    /**
     * Set master Class Cohort
     *
     * @param  MasterClassCohort  $masterClassCohort  Master Class Cohort
     *
     * @return  self
     */
    public function setMasterClassCohort(MasterClassCohort $masterClassCohort)
    {
        $this->masterClassCohort = $masterClassCohort;

        return $this;
    }

    /**
     * Get *Defines if the resos is for every general use and not restricted by cohort
     *
     * @return  boolean
     */
    public function getIsGeneral()
    {
        return $this->isGeneral;
    }

    /**
     * Set *Defines if the resos is for every general use and not restricted by cohort
     *
     * @param  boolean  $isGeneral  *Defines if the resos is for every general use and not restricted by cohort
     *
     * @return  self
     */
    public function setIsGeneral(bool $isGeneral)
    {
        $this->isGeneral = $isGeneral;

        return $this;
    }

    /**
     * Get defines the speific type of room the resos is meant for
     *
     * @return  RoomType
     */
    public function getRoomType()
    {
        return $this->roomType;
    }

    /**
     * Set defines the speific type of room the resos is meant for
     *
     * @param  RoomType  $roomType  defines the speific type of room the resos is meant for
     *
     * @return  self
     */
    public function setRoomType(RoomType $roomType)
    {
        $this->roomType = $roomType;

        return $this;
    }
}
