<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 *  @ORM\Entity
 * @ORM\Table(name="coupon")
 */
class Coupon
{

    /**
     *
     * @var int 
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, options={"default":"5"})
     * @var string
     */
    private $percentage = 5;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false, unique=true)
     * @var string
     */
    private $coupon = 0000000;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \Datetime
     */
    private $expiryDate;

    /**
     * Undocumented variable
     *@ORM\Column(type="boolean", options={"default":0}, nullable=false)
     * @var bool
     */
    private $isUsed;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \Datetime
     */
    private $updatedOn;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Programs")
     * @var Programs
     */
    private Programs $beingFor;

    /**
     * Get the value of id
     *
     * @return  int
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
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $coupon  Undocumented variable
     *
     * @return  self
     */
    public function setCoupon(string $coupon)
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $expiryDate  Undocumented variable
     *
     * @return  self
     */
    public function setExpiryDate(\Datetime $expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Get *@ORM\Column(type="boolean", options={"default":0}, nullable=false)
     *
     * @return  bool
     */
    public function getIsUsed()
    {
        return $this->isUsed;
    }

    /**
     * Set *@ORM\Column(type="boolean", options={"default":0}, nullable=false)
     *
     * @param  bool  $isUsed  *@ORM\Column(type="boolean", options={"default":0}, nullable=false)
     *
     * @return  self
     */
    public function setIsUsed(bool $isUsed)
    {
        $this->isUsed = $isUsed;

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
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $percentage  Undocumented variable
     *
     * @return  self
     */
    public function setPercentage(string $percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get undocumented variable
     * @ORM
     * @return  Programs
     */ 
    public function getBeingFor()
    {
        return $this->beingFor;
    }

    /**
     * Set undocumented variable
     *
     * @param  Programs  $beingFor  Undocumented variable
     *
     * @return  self
     */ 
    public function setBeingFor(Programs $beingFor)
    {
        $this->beingFor = $beingFor;

        return $this;
    }
}
