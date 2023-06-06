<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="programss")
 */

class Programs
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    private $cost;

    private $title;

    private $duration;

    // private $desHeader;

    private $description; // 

    private $createdOn;

    private $updatedon;


    private $name;
}
