<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(nullable=true)
     * @var string
     */
    private string $cohort;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     * @var boolean
     */
    private bool $isActive;

    /**
     * Undocumented variable
     * @ORM\Column(type="date", nullable=false)
     * @var \DateTime
     */
    private \DateTime $startDate;


    public function __construct()
    {
        $this->startDate = new \DateTime();
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
     * @return  string
     */
    public function getCohort()
    {
        return $this->cohort;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $cohort  Undocumented variable
     *
     * @return  self
     */
    public function setCohort(string $cohort)
    {
        $this->cohort = $cohort;

        return $this;
    }
}
