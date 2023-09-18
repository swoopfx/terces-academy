<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\Courses;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Application\Entity\QuizQuestion;


/**
 * @ORM\Entity
 * @ORM\Table(name="quiz")
 */

class Quiz
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
     * @ORM\OneToOne(targetEntity="Application\Entity\Courses", inversedBy="quiz")
     * @var Courses
     */
    private $course;

    /**
     * Undocumented variable
     * @ORM\OneToMany(targetEntity="QuizQuestion", mappedBy="quiz")
     * @var Collection
     */
    private $questions;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $uuid;



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


    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

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
     * @return  Courses
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set undocumented variable
     *
     * @param  Courses  $course  Undocumented variable
     *
     * @return  self
     */
    public function setCourse(Courses $course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $uuid  Undocumented variable
     *
     * @return  self
     */
    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $createdOn  Undocumented variable
     *
     * @return  self
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $updatedOn  Undocumented variable
     *
     * @return  self
     */
    public function setUpdatedOn(string $updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    public function addQuestions($question)
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            // $question-
        }
        return $this;
    }
}
