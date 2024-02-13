<?php

namespace Internship\Entity;

use Doctrine\ORM\Mapping as ORM;
use Internship\Entity\Assignments;
use Application\Entity\Resources;

/**
 * These are resources attached to an assignment
 * @ORM\Entity
 * @ORM\Table(name="assignment_resos")
 */


class AssignmentResos
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
     * @ORM\ManyToOne(targetEntity="Internship\Entity\Assignments")
     * @var Assignments
     */
    private $assignment;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Application\Entity\Resources")
     * @var Resources
     */
    private $aResources;

    /**
     * Undocumented variable
     * @ORM\Column()
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     *
     * @var \Datetime
     */
    private $updatedOn;

    // private $
}
