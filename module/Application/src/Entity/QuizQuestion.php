<?php

namespace Application\Entity;

use Application\Entity\QuizAnswer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Application\Entity\Quiz;

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
     * Undocumented variable
     * @ORM\OneToMany(targetEntity="QuizAnswer", mappedBy="question")
     * @var Collection
     */
    private $answer;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="questions")
     * @var Quiz
     */
    private $quiz;


    public function __construct()
    {
        $this->answer = new ArrayCollection();
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
    public function setQuestion(string $question)
    {
        $this->question = $question;

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
     * @return  Collection
     */
    public function getAnswer()
    {
        return $this->answer;
    }


    public function addAnswer(QuizAnswer $answer)
    {
        if (!$this->answer->contains($answer)) {
            $this->answer->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set undocumented variable
     *
     * @param  Quiz  $quiz  Undocumented variable
     *
     * @return  self
     */
    public function setQuiz(Quiz $quiz)
    {
        $this->quiz = $quiz;

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
     * @return  bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isActive  Undocumented variable
     *
     * @return  self
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
}
