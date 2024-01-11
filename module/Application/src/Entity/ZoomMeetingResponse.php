<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\ZoomMeetingType;
use Authentication\Entity\User;

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
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private $user;

    /**
     * Undocumented variable
     *  @ORM\Column(nullable=false)
     * @var string
     */
    private $zoomAssitantId;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $zoomRegUrl;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $zoomMeetingPassword;

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
}
