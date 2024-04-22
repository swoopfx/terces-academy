<?php

namespace General\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="room_type")
 */

class RoomType
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $type;

    /**
     * Get @ORM\Column(name="id", type="integer", nullable=false)
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $type  Undocumented variable
     *
     * @return  self
     */ 
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
}
