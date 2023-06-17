<?php

namespace Application\Entity;

use Application\Entity\CourseContent;
use Application\Entity\ResourceType;
use General\Entity\Image;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="resourcess")
 */

class Resources
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
     * @ORM\ManyToOne(targetEntity="Application\Entity\CourseContent", inversedBy="resources")
     * @var CourseContent
     */
    private $courseContent;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\ResourceType")
     * @var ResourceType
     */
    private $resourcesType;

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
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $resourceDesc;

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
     * @return  ResourceType
     */
    public function getResourcesType()
    {
        return $this->resourcesType;
    }

    /**
     * Set undocumented variable
     *
     * @param  ResourceType  $resourcesType  Undocumented variable
     *
     * @return  self
     */
    public function setResourcesType(ResourceType $resourcesType)
    {
        $this->resourcesType = $resourcesType;

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
     * @return  string
     */
    public function getResourceDesc()
    {
        return $this->resourceDesc;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $resourceDesc  Undocumented variable
     *
     * @return  self
     */
    public function setResourceDesc(string $resourceDesc)
    {
        $this->resourceDesc = $resourceDesc;

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
