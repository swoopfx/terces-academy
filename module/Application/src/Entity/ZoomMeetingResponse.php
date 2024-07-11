<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\ZoomMeetingType;
use Authentication\Entity\User;
use Application\Entity\Programs;

/**
 * @ORM\Entity
 * @ORM\Table(name="zoom_meeting_response")
 */
class ZoomMeetingResponse
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
    private string $zoomTitle;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private string $zoomStartTime;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false) 
     * @var string
     */
    private string $zoomDuration;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, options={"default":"UTC"}) 
     * @var string
     */
    private string $zoomTimeZone;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="ZoomMeetingType")
     * @var ZoomMeetingType
     */
    private $type;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $zoomId;

    /**
     * Undocumented variable
     * @ORM\Column(unique=true, nullable=false, type="string")
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private $user;

    /**
     * Undocumented variable
     *  @ORM\Column(nullable=true)
     * @var string
     */
    private $zoomAssitantId;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, type="text")
     * @var string
     */
    private $zoomRegUrl;

    /**
     * Undocumented variable
     *  @ORM\Column(nullable=false, type="text")
     * @var string
     */
    private $zoomJoinUrl;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $zoomMeetingPassword;

    /**
     * The Zoom host ID
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $zoomhostId;

    /**
     * the uuid of the zoom response 
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $zoomUuid;


    /**
     * The whole response onbject serialized
     * @ORM\Column(nullable=true, type="text")
     * @var string
     */
    private $zoomResponse;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $zoomPassword;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $zoomEncryptPassword;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var \Datetime 
     */
    private $createdOn;

    /**
     * 
     * @ORM\Column(type="datetime")
     * @var \Datetime
     */
    private $updatedOn;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\Programs")
     * @var Programs
     */
    private Programs $program;

    /**
     * reference to master class cohort
     * @ORM\ManyToOne(targetEntity="MasterClassCohort")
     * @var MasterClassCohort
     */
    private MasterClassCohort $freeBusinessMasterClassCohort;

    /**
     * Undocumented variable
     * @ORM\ManytoOne(targetEntity="InternshipCohort")
     * @var InternshipCohort
     */
    private InternshipCohort $businessAnalysisCohort;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="P6FreeCohort")
     * @var P6FreeCohort
     */
    private P6FreeCohort $freeOracleCohort;

    // private $businessAnalysisCohort;


    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="P6Cohort")
     * @var P6Cohort
     */
    private P6Cohort $oracleP6Cohort;

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
     * @return  ZoomMeetingType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set undocumented variable
     *
     * @param  ZoomMeetingType  $type  Undocumented variable
     *
     * @return  self
     */
    public function setType(ZoomMeetingType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getZoomId()
    {
        return $this->zoomId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomId  Undocumented variable
     *
     * @return  self
     */
    public function setZoomId(string $zoomId)
    {
        $this->zoomId = $zoomId;

        return $this;
    }

    /**
     * Get undocumented variable
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set undocumented variable
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getZoomAssitantId()
    {
        return $this->zoomAssitantId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomAssitantId  Undocumented variable
     *
     * @return  self
     */
    public function setZoomAssitantId(string $zoomAssitantId)
    {
        $this->zoomAssitantId = $zoomAssitantId;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getZoomRegUrl()
    {
        return $this->zoomRegUrl;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomRegUrl  Undocumented variable
     *
     * @return  self
     */
    public function setZoomRegUrl(string $zoomRegUrl)
    {
        $this->zoomRegUrl = $zoomRegUrl;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getZoomMeetingPassword()
    {
        return $this->zoomMeetingPassword;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomMeetingPassword  Undocumented variable
     *
     * @return  self
     */
    public function setZoomMeetingPassword(string $zoomMeetingPassword)
    {
        $this->zoomMeetingPassword = $zoomMeetingPassword;

        return $this;
    }

    /**
     * Get the value of updatedOn
     *
     * @return  \Datetime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set the value of updatedOn
     *
     * @param  \Datetime  $updatedOn
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
    public function getZoomJoinUrl()
    {
        return $this->zoomJoinUrl;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomJoinUrl  Undocumented variable
     *
     * @return  self
     */
    public function setZoomJoinUrl(string $zoomJoinUrl)
    {
        $this->zoomJoinUrl = $zoomJoinUrl;

        return $this;
    }

    /**
     * Get the Zoom host ID
     *
     * @return  string
     */
    public function getZoomhostId()
    {
        return $this->zoomhostId;
    }

    /**
     * Set the Zoom host ID
     *
     * @param  string  $zoomhostId  The Zoom host ID
     *
     * @return  self
     */
    public function setZoomhostId(string $zoomhostId)
    {
        $this->zoomhostId = $zoomhostId;

        return $this;
    }

    /**
     * Get the uuid of the zoom response
     *
     * @return  string
     */
    public function getZoomUuid()
    {
        return $this->zoomUuid;
    }

    /**
     * Set the uuid of the zoom response
     *
     * @param  string  $zoomUuid  the uuid of the zoom response
     *
     * @return  self
     */
    public function setZoomUuid(string $zoomUuid)
    {
        $this->zoomUuid = $zoomUuid;

        return $this;
    }

    /**
     * Get the whole response onbject serialized
     *
     * @return  string
     */
    public function getZoomResponse()
    {
        return $this->zoomResponse;
    }

    /**
     * Set the whole response onbject serialized
     *
     * @param  string  $zoomResponse  The whole response onbject serialized
     *
     * @return  self
     */
    public function setZoomResponse(string $zoomResponse)
    {
        $this->zoomResponse = $zoomResponse;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getZoomPassword()
    {
        return $this->zoomPassword;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomPassword  Undocumented variable
     *
     * @return  self
     */
    public function setZoomPassword(string $zoomPassword)
    {
        $this->zoomPassword = $zoomPassword;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getZoomEncryptPassword()
    {
        return $this->zoomEncryptPassword;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomEncryptPassword  Undocumented variable
     *
     * @return  self
     */
    public function setZoomEncryptPassword(string $zoomEncryptPassword)
    {
        $this->zoomEncryptPassword = $zoomEncryptPassword;

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
     * Get reference to master class cohort
     *
     * @return  MasterClassCohort
     */
    public function getFreeBusinessMasterClassCohort()
    {
        return $this->freeBusinessMasterClassCohort;
    }

    /**
     * Set reference to master class cohort
     *
     * @param  MasterClassCohort  $freeBusinessMasterClassCohort  reference to master class cohort
     *
     * @return  self
     */
    public function setFreeBusinessMasterClassCohort(MasterClassCohort $freeBusinessMasterClassCohort)
    {
        $this->freeBusinessMasterClassCohort = $freeBusinessMasterClassCohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  P6FreeCohort
     */
    public function getFreeOracleCohort()
    {
        return $this->freeOracleCohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  P6FreeCohort  $freeOracleCohort  Undocumented variable
     *
     * @return  self
     */
    public function setFreeOracleCohort(P6FreeCohort $freeOracleCohort)
    {
        $this->freeOracleCohort = $freeOracleCohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  InternshipCohort
     */
    public function getBusinessAnalysisCohort()
    {
        return $this->businessAnalysisCohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  InternshipCohort  $businessAnalysisCohort  Undocumented variable
     *
     * @return  self
     */
    public function setBusinessAnalysisCohort(InternshipCohort $businessAnalysisCohort)
    {
        $this->businessAnalysisCohort = $businessAnalysisCohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  P6Cohort
     */
    public function getOracleP6Cohort()
    {
        return $this->oracleP6Cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  P6Cohort  $oracleP6Cohort  Undocumented variable
     *
     * @return  self
     */
    public function setOracleP6Cohort(P6Cohort $oracleP6Cohort)
    {
        $this->oracleP6Cohort = $oracleP6Cohort;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getZoomTitle()
    {
        return $this->zoomTitle;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomTitle  Undocumented variable
     *
     * @return  self
     */
    public function setZoomTitle(string $zoomTitle)
    {
        $this->zoomTitle = $zoomTitle;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getZoomStartTime()
    {
        return $this->zoomStartTime;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomStartTime  Undocumented variable
     *
     * @return  self
     */
    public function setZoomStartTime(string $zoomStartTime)
    {
        $this->zoomStartTime = $zoomStartTime;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getZoomDuration()
    {
        return $this->zoomDuration;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomDuration  Undocumented variable
     *
     * @return  self
     */
    public function setZoomDuration(string $zoomDuration)
    {
        $this->zoomDuration = $zoomDuration;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */ 
    public function getZoomTimeZone()
    {
        return $this->zoomTimeZone;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $zoomTimeZone  Undocumented variable
     *
     * @return  self
     */ 
    public function setZoomTimeZone(string $zoomTimeZone)
    {
        $this->zoomTimeZone = $zoomTimeZone;

        return $this;
    }
}
