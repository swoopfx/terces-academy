<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acquired
 * Started
 * Completed
 * Canceled
 * @ORM\Entity
 * @ORM\Table(name="active_user_program_status")
 */

class ActiveUserProgramStatus
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
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
     * Get @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *
     * @return  int
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
