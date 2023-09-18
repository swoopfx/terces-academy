<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Undocumented class
 * @ORM\Entity
 * @ORM\Table(name="internship_register")
 */
class InternshipRegister
{
    /**
     *
     * @var integer 
     * @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    private $user;

    private $createdOn;

    private $updatedOn;
}
