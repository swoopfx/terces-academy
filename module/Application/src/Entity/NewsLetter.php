<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Undocumented class
 * @ORM\Entity
 * @ORM\Table(name="news_letter")
 */
class NewsLetter
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
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $email;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $activeCampaignId;

    /**
     * Undocumented variable
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $activeCampaignResponseData;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="datetime")
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="datetime")
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
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $email  Undocumented variable
     *
     * @return  self
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

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
     * @return  string
     */
    public function getActiveCampaignId()
    {
        return $this->activeCampaignId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $activeCampaignId  Undocumented variable
     *
     * @return  self
     */
    public function setActiveCampaignId(string $activeCampaignId)
    {
        $this->activeCampaignId = $activeCampaignId;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getActiveCampaignResponseData()
    {
        return $this->activeCampaignResponseData;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $activeCampaignResponseData  Undocumented variable
     *
     * @return  self
     */
    public function setActiveCampaignResponseData(string $activeCampaignResponseData)
    {
        $this->activeCampaignResponseData = $activeCampaignResponseData;

        return $this;
    }
}
