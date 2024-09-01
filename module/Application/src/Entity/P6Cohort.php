<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="p6cohort")
 */
class P6Cohort
{

    /**
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, name="cohort")
     * @var string
     */
    private string $cohortName;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     * @var boolean
     */
    private bool $isActive;

    /**
     * Undocumented variable
     * @ORM\Column(unique=true, nullable=true, type="string")
     * @var string
     */
    private string $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(type="date", nullable=false)
     * @var \DateTime
     */
    private \DateTime $startDate;

    /**
     * Undocumented variable
     *
     * @var \DateTime
     */
    private \DateTime $createdOn;


    public function __construct()
    {
        $this->startDate = new \DateTime();
        $this->uuid = (Uuid::uuid4())->toString();
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

    /**
     * Set @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *
     * @param  int  $id  @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

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

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set undocumented variable
     *
     * @param  boolean  $isActive  Undocumented variable
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
     * @return  \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set undocumented variable
     *
     * @param  \DateTime  $startDate  Undocumented variable
     *
     * @return  self
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;

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
    public function getCohortName()
    {
        return $this->cohortName;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $cohortName  Undocumented variable
     *
     * @return  self
     */
    public function setCohortName(string $cohortName)
    {
        $this->cohortName = $cohortName;

        return $this;
    }
}
