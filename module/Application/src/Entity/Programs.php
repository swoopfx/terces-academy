<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="programss")
 */

class Programs
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
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $programId;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $cost;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $title;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $duration;

    // private $desHeader;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="text")
     * @var string
     */
    private $description; //

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var string
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var string
     */
    private $updatedon;

    /**
     * @ORM\Column(name="isActive", type="boolean", nullable=true, options={"default":"1"})
     * @var boolean
     */
    private $isActive;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $banner;

    /**
     * Undocumented variable
     * @ORM\OneToMany(targetEntity="Courses", mappedBy="programs" , cascade={"remove"})
     * @var Collection
     */
    private $courses;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $instructor;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
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
    public function getProgramId()
    {
        return $this->programId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $programId  Undocumented variable
     *
     * @return  self
     */
    public function setProgramId(string $programId)
    {
        $this->programId = $programId;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $cost  Undocumented variable
     *
     * @return  self
     */
    public function setCost(string $cost)
    {
        $this->cost = $cost;

        return $this;
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
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $duration  Undocumented variable
     *
     * @return  self
     */
    public function setDuration(string $duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $description  Undocumented variable
     *
     * @return  self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $createdOn  Undocumented variable
     *
     * @return  self
     */
    public function setCreatedOn(string $createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedon = $createdOn;
        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getUpdatedon()
    {
        return $this->updatedon;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $updatedon  Undocumented variable
     *
     * @return  self
     */
    public function setUpdatedon(string $updatedon)
    {
        $this->updatedon = $updatedon;

        return $this;
    }

    /**
     * Get the value of isActive
     *
     * @return  boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the value of isActive
     *
     * @param  boolean  $isActive
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
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $banner  Undocumented variable
     *
     * @return  self
     */
    public function setBanner(string $banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getInstructor()
    {
        return $this->instructor;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $instructor  Undocumented variable
     *
     * @return  self
     */
    public function setInstructor(string $instructor)
    {
        $this->instructor = $instructor;

        return $this;
    }
}
