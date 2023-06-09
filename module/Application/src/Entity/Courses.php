<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\Programs;
use General\Entity\Image;

/**
 * @ORM\Entity
 * @ORM\Table(name="courses")
 */

class Courses
{
    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(nullable=false)
     *
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\Programs")
     * @var Programs
     */
    private $programs;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $title;

    /**
     * Undocumented variable
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $description;

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
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="General\Entity\Image")
     * @var Image
     */
    private $banner;

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
     * Get the value of uuid
     *
     * @return  string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set the value of uuid
     *
     * @param  string  $uuid
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
     * @return  Programs
     */
    public function getPrograms()
    {
        return $this->programs;
    }

    /**
     * Set undocumented variable
     *
     * @param  Programs  $programs  Undocumented variable
     *
     * @return  self
     */
    public function setPrograms(Programs $programs)
    {
        $this->programs = $programs;

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
}