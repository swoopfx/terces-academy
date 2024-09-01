<?php

namespace Application\Entity;

use Admin\Entity\OracleClasses;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="active_zoom_class_id")
 */
class ActiveZoomClassId
{
    /**
     *
     * @var int 
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private  $id;

    /**
     * Undocumented variable
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    private $cohort;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Programs")
     * @var Programs
     */
    private Programs $program;


    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="ZoomMeetingResponse")
     * @var ZoomMeetingResponse
     */
    private ZoomMeetingResponse $zoomResponse;

    /**
     * Undocumented variable
     * @ORM\Column(type="integer", nullable=true)
     * @var integer
     */
    private int  $classRoomId;

    /**
     * Undocumented variable
     *  @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private \DateTime $createdOn;

    /**
     * Undocumented variable
     *  @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private \DateTime $updatedOn;

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
     * Get undocumented variable
     *
     * @return  int
     */
    public function getCohort()
    {
        return $this->cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  int  $cohort  Undocumented variable
     *
     * @return  self
     */
    public function setCohort(int $cohort)
    {
        $this->cohort = $cohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Programs
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Set undocumented variable
     *
     * @param  Programs  $program  Undocumented variable
     *
     * @return  self
     */
    public function setProgram(Programs $program)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  ZoomMeetingResponse
     */
    public function getZoomResponse()
    {
        return $this->zoomResponse;
    }

    /**
     * Set undocumented variable
     *
     * @param  ZoomMeetingResponse  $zoomResponse  Undocumented variable
     *
     * @return  self
     */
    public function setZoomResponse(ZoomMeetingResponse $zoomResponse)
    {
        $this->zoomResponse = $zoomResponse;

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

    /**
     * Get undocumented variable
     *
     * @return  integer
     */ 
    public function getClassRoomId()
    {
        return $this->classRoomId;
    }

    /**
     * Set undocumented variable
     *
     * @param  integer  $classRoomId  Undocumented variable
     *
     * @return  self
     */ 
    public function setClassRoomId($classRoomId)
    {
        $this->classRoomId = $classRoomId;

        return $this;
    }
}
