<?php

namespace Admissions\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Undocumented class
 * @ORM\Entity
 * @ORM\Table(name="canadian_banks")
 */
class CanadianBanks
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
    private $bankName;

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
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $bankName  Undocumented variable
     *
     * @return  self
     */ 
    public function setBankName(string $bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }
}
