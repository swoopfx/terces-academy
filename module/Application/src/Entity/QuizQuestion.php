<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="quiz_question")
 */

class QuizQuestion
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
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $type;

    /**
     * Undocumented variable
     * @ORM\Column(type="text")
     * @var string
     */
    private $question;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var \Datetime
     */
    private $updatedOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", options={"default":"1"})
     * @var bool
     */
    private $isActive;

    /**
     * Get @ORM\Column(name="id", type="integer")
     *
     * @return  integer
     */ 
    public function getId()
    {
        return $this->id;
    }
}
