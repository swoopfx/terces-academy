<?php

namespace Admissions\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Interac
 * Bank Transafer
 * @ORM\Entity
 * @ORM\Table(name="send_money_service_type")
 */
class SendMoneyService
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
    private $service;

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
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $service  Undocumented variable
     *
     * @return  self
     */
    public function setService(string $service)
    {
        $this->service = $service;

        return $this;
    }
}
