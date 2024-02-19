<?php

namespace Admin\Entity;

use Application\Entity\InternshipCohort;
use Doctrine\ORM\Mapping as ORM;
use General\Entity\Image;

/**
 * @ORM\Entity
 * @ORM\Table(name="zoom_video")
 */
class ZoomVideo
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
    private string $titles;

    /**
     * Undocumented variable
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private string $descs;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\InternshipCohort")
     * @var  InternshipCohort 
     */
    private InternshipCohort $cohort;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="General\Entity\Image")
     * @var Image 
     */
    private Image $video;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     * @var bool
     */
    private bool $isActive;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private string $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private \DateTime $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private \DateTime $updatedOn;

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
    public function getTitles()
    {
        return $this->titles;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $titles  Undocumented variable
     *
     * @return  self
     */
    public function setTitles(string $titles)
    {
        $this->titles = $titles;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getDescs()
    {
        return $this->descs;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $descs  Undocumented variable
     *
     * @return  self
     */
    public function setDescs(string $descs)
    {
        $this->descs = $descs;

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
     * Get undocumented variable
     *
     * @return  Image
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set undocumented variable
     *
     * @param  Image  $video  Undocumented variable
     *
     * @return  self
     */
    public function setVideo(Image $video)
    {
        $this->video = $video;

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
