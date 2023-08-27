<?php

namespace Application\Entity;


use Application\Entity\QuizQuestion;
use Doctrine\ORM\Mapping as ORM;

/**
 * Undocumented class
 * @ORM\Entity
 * @ORM\Table(name="quiz_answer")
 */
class QuizAnswer
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
     * @ORM\ManyToOne(targetEntity="QuizQuestion", inversedBy="answer")
     * @var QuizQuestion
     */
    private $question;

    /**
     * Undocumented variab
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $uuid;

    // private $course

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $answerText;

    /**
     * Undocumented variable
     * @ORM\Column(type="boolean", options={"default":0})
     * @var bool
     */
    private $isAnswer;

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
     * Get @ORM\Column(name="id", type="integer")
     *
     * @return  integer
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Get undocumented variab
     *
     * @return  string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set undocumented variab
     *
     * @param  string  $uuid  Undocumented variab
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
    public function getAnswerText()
    {
        return $this->answerText;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $answerText  Undocumented variable
     *
     * @return  self
     */
    public function setAnswerText(string $answerText)
    {
        $this->answerText = $answerText;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  bool
     */
    public function getIsAnswer()
    {
        return $this->isAnswer;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isAnswer  Undocumented variable
     *
     * @return  self
     */
    public function setIsAnswer(bool $isAnswer)
    {
        $this->isAnswer = $isAnswer;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $createdOn  Undocumented variable
     *
     * @return  self
     */
    public function setCreatedOn(\Datetime $createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $updatedOn  Undocumented variable
     *
     * @return  self
     */
    public function setUpdatedOn(\Datetime $updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $question  Undocumented variable
     *
     * @return  self
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }
}
