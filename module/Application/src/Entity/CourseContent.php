<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use General\Entity\Image;
use Application\Entity\Courses;

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
     * @ORM\ManyToOne(targetEntity="Application\Entity\Courses")
     *
     * @var Courses
     */
    private $courses;


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
}
