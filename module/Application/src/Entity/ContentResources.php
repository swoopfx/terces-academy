<?php

namespace Application\Entity;

use Application\Entity\CourseContent;
use Doctrine\ORM\Mapping as ORM;
use General\Entity\Image;

class ContentResources {

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="General\Entity\Image")
     * @var Image
     */
    private $resource;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="CourseContent")
     * @var CourseContent
     */
    private $courseContent;

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
     * @return  Image
     */ 
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set undocumented variable
     *
     * @param  Image  $resource  Undocumented variable
     *
     * @return  self
     */ 
    public function setResource(Image $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  CourseContent
     */ 
    public function getCourseContent()
    {
        return $this->courseContent;
    }

    /**
     * Set undocumented variable
     *
     * @param  CourseContent  $courseContent  Undocumented variable
     *
     * @return  self
     */ 
    public function setCourseContent(CourseContent $courseContent)
    {
        $this->courseContent = $courseContent;

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
}