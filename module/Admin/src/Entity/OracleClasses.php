<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This provides a list of weekly activity for the oracle classes 
 * @ORM\Entity
 * @ORM\Table(name="oracle_classes")
 */
class OracleClasses
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
    private string $weekName;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private string $weekDefinition;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="text")
     * @var string
     */
    private string $weekDesc;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, type="datetime")
     * @var string
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(unique=true, nullable=false)
     * @var string
     */
    private string $uuid;

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
    public function getWeekName()
    {
        return $this->weekName;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $weekName  Undocumented variable
     *
     * @return  self
     */
    public function setWeekName(string $weekName)
    {
        $this->weekName = $weekName;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getWeekDefinition()
    {
        return $this->weekDefinition;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $weekDefinition  Undocumented variable
     *
     * @return  self
     */
    public function setWeekDefinition(string $weekDefinition)
    {
        $this->weekDefinition = $weekDefinition;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getWeekDesc()
    {
        return $this->weekDesc;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $weekDesc  Undocumented variable
     *
     * @return  self
     */
    public function setWeekDesc(string $weekDesc)
    {
        $this->weekDesc = $weekDesc;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $createdOn  Undocumented variable
     *
     * @return  self
     */
    public function setCreatedOn(string $createdOn)
    {
        $this->createdOn = $createdOn;

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
}
