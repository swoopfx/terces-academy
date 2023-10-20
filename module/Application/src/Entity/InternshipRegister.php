<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Authentication\Entity\User;

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

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private $user;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $cohort;

    private $createdOn;

    private $updatedOn;
}
