<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use General\Entity\Image;
use Application\Entity\Courses;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="course_content")
 */

class CourseContent
{
    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var int 
     * @ORM\Column(type="integer", unique=true, nullable=false, options={"unsigned"=true})
     *      
     *      
     */
    private $arrange;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $title;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="General\Entity\Image")
     * @var Image
     */
    private $banner;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $snippetVideo;

    /**
     * @ORM\Column(name="course_video", type="string", nullable=true)
     *
     * @var string
     */
    private $video;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     *
     * @var boolean
     */
    private $isActive;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedOn;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Courses", inversedBy="courseContent")
     *
     * @var Courses
     */
    private $courses;


    /**
     * Undocumented variable
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $description;

    /**
     * Undocumented variable
     * @ORM\OneToMany(targetEntity="Resources", mappedBy="courseContent")
     * @var Collection
     */
    private $resources;


    public function __construct()
    {
        $this->resources = new ArrayCollection();
    }


    /**
     * Get @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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
     * Get the value of title
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
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
     * @return  Image
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set undocumented variable
     *
     * @param  Image  $banner  Undocumented variable
     *
     * @return  self
     */
    public function setBanner(Image $banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get the value of video
     *
     * @return  string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set the value of video
     *
     * @param  string  $video
     *
     * @return  self
     */
    public function setVideo(string $video)
    {
        $this->video = $video;

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
     * Get the value of createdOn
     *
     * @return  \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set the value of createdOn
     *
     * @param  \DateTime  $createdOn
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
     * Get the value of updatedOn
     *
     * @return  \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set the value of updatedOn
     *
     * @param  \DateTime  $updatedOn
     *
     * @return  self
     */
    public function setUpdatedOn(\DateTime $updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get the value of courses
     *
     * @return  Courses
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set the value of courses
     *
     * @param  Courses  $courses
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
     * Get the value of snippetVideo
     *
     * @return  string
     */
    public function getSnippetVideo()
    {
        return $this->snippetVideo;
    }

    /**
     * Set the value of snippetVideo
     *
     * @param  string  $snippetVideo
     *
     * @return  self
     */
    public function setSnippetVideo(string $snippetVideo)
    {
        $this->snippetVideo = $snippetVideo;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Collection
     */
    public function getResources()
    {
        return $this->resources;
    }

    public function addResources(Resources $res)
    {
        if (!$this->resources->contains($res)) {
            $this->resources->add($res);
            $res->setCourseContent($this);
        }

        return $this;
    }



    /**
     * Get the value of arrange
     *
     * @return  int
     */
    public function getArrange()
    {
        return $this->arrange;
    }

    /**
     * Set the value of arrange
     *
     * @param  int  $arrange
     *
     * @return  self
     */
    public function setArrange(int $arrange)
    {
        $this->arrange = $arrange;

        return $this;
    }
}
