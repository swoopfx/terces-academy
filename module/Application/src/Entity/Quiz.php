<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\Courses;


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
     * @ORM\ManyToOne(targetEntity="Application\Entity\Courses", inversedBy="quiz")
     * @var Courses
     */
    private $course;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $uuid;


    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $quizId;


    /**
     * Undocumented variable
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $title;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var string
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime")
     * @var string
     */
    private $updatedOn;

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
    public function getQuizId()
    {
        return $this->quizId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $quizId  Undocumented variable
     *
     * @return  self
     */
    public function setQuizId(string $quizId)
    {
        $this->quizId = $quizId;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $title  Undocumented variable
     *
     * @return  self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

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
    public function setCreatedOn(string $createdOn)
    {
        $this->createdOn = $createdOn;

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
}
