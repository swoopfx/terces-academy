<?php

namespace Application\Entity;

use Application\Entity\Courses;
use General\Entity\Image;
use Doctrine\ORM\Mapping as ORM;


/**
 * Undocumented class 
 * @ORM\Entity
 * @ORM\Table(name="course_resource")
 */
class CourseResource
{
    /**
     *
     * @var int 
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(nullable=false, unique=true)
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Courses", inversedBy="courseResource")
     * @var Courses
     */
    private $courses;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $resourceTitle;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="General\Entity\Image")
     * @var Image
     */
    private $resourceFile;



    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var \Datetime
     */
    private $updatedOn;

    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set the value of uuid
     *
     * @return  self
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Courses
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set undocumented variable
     *
     * @param  Courses  $courses  Undocumented variable
     *
     * @return  self
     */
    public function setCourses(Courses $courses)
    {
        $this->courses = $courses;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getResourceTitle()
    {
        return $this->resourceTitle;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $resourceTitle  Undocumented variable
     *
     * @return  self
     */
    public function setResourceTitle(string $resourceTitle)
    {
        $this->resourceTitle = $resourceTitle;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Image
     */
    public function getResourceFile()
    {
        return $this->resourceFile;
    }

    /**
     * Set undocumented variable
     *
     * @param  Image  $resourceFile  Undocumented variable
     *
     * @return  self
     */
    public function setResourceFile(Image $resourceFile)
    {
        $this->resourceFile = $resourceFile;

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
