<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Assignement
 * Document
 * Class Work 
 * 
 * @ORM\Entity
 * @ORM\Table(name="resource_type")
 */
class ResourceType
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
    private $type;



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
