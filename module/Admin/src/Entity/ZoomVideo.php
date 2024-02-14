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
     * @var 
     */
    private  string $title;

    /**
     * Undocumented variable
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private string $descs;

    /**
     * Undocumented variable
     *
     * @var  InternshipCohort 
     */
    private InternshipCohort $cohort;

    /**
     * Undocumented variable
     *
     * @var Image 
     */
    private Image $video;

    private bool $isActive;

    private string $uuid;

    /**
     * Undocumented variable
     *
     * @var \DateTime
     */
    private \DateTime $createdOn;

    private \DateTime $updatedOn;
}
