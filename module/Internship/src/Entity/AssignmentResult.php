<?php

namespace Internship\Entity;

use Doctrine\ORM\Mapping as ORM;
use Authentication\Entity\User;
use Internship\Entity\Assignments;
use General\Entity\Image;

/**
 * @ORM\Entity
 * @ORM\Table(name="assignment_result")
 * 
 */
class AssignmentResult
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
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @var User
     */
    private $user;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Internship\Entity\Assignments")
     * @var Assignments
     */
    private $assignment;

    /**
     * Undocumented variable
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $result;

    /**
     * Undocumented variable
     *@ORM\OneToMany(targetEntity="General\Entity\Image", mappedBy="assignResultResos" , cascade={"remove"})
     * @var Collection
     */
    private $resultResos;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="datetime")
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=true, type="datetime")
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
     * Set @ORM\Column(name="id", type="integer")
     *
     * @param  integer  $id  @ORM\Column(name="id", type="integer")
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set undocumented variable
     *
     * @param  User  $user  Undocumented variable
     *
     * @return  self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Assignments
     */
    public function getAssignment()
    {
        return $this->assignment;
    }

    /**
     * Set undocumented variable
     *
     * @param  Assignments  $assignment  Undocumented variable
     *
     * @return  self
     */
    public function setAssignment(Assignments $assignment)
    {
        $this->assignment = $assignment;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $result  Undocumented variable
     *
     * @return  self
     */
    public function setResult(string $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get *@ORM\OneToMany(targetEntity="General\Entity\Image", mappedBy="assignResultResos" , cascade={"remove"})
     *
     * @return  Collection
     */
    public function getResultResos()
    {
        return $this->resultResos;
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
}
