<?php

namespace Admissions\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Interac
 * Bank Transafer
 * @ORM\Entity
 * @ORM\Table(name="send_money_status")
 */
class SendMoneyStatus
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
    private $status;

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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $status  Undocumented variable
     *
     * @return  self
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }
}
