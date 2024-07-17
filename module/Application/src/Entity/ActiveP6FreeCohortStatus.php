<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="actvie_p6_free_status")
 */
class ActiveP6FreeCohortStatus

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
}
