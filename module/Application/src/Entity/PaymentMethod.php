<?php

namespace Application\Entity;


use Doctrine\ORM\Mapping as ORM;
use General\Entity\Image;

/**
 * Paypal
 * FlutterWave
 * Paystack
 * Interac
 * 
 * @ORM\Entity
 * @ORM\Table(name="payment_method")
 */

class PaymentMethod
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
    private $method;

    /**
     * Undocumented variable
     *  @ORM\Column(nullable=true, type="text")
     * @var string
     */
    private $decription;

    /**
     * Undocumented variable
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $image;

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

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $method  Undocumented variable
     *
     * @return  self
     */
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getDecription()
    {
        return $this->decription;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $decription  Undocumented variable
     *
     * @return  self
     */
    public function setDecription(string $decription)
    {
        $this->decription = $decription;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set undocumented variable
     *
     * @param  Image  $image  Undocumented variable
     *
     * @return  self
     */
    public function setImage(String $image)
    {
        $this->image = $image;

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
