<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Initiated
 * Completed, 
 * Revesed, 
 * Failed, 
 * 
 * @ORM\Entity
 * @ORM\Table(name="transaction_status")
 */
class TransactionStatus
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
