<?php

namespace General\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Undocumented class
 * @ORM\Entity
 * @ORM\Table(name="settings")
 */
class Settings
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\Column(type="text")
     * @var string
     */
    private $flutterwavePublicKey;

    /**
     * Undocumented variable
     * @ORM\Column(type="text")
     * @var string
     */
    private $flutterwaveSecretKey;

    /**
     * Undocumented variable
     * @ORM\Column(type="text")
     * @var string
     */
    private $flutterwaveEncKey;

    /**
     * Get @ORM\Column(name="id", type="integer", nullable=false)
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
    public function getFlutterwavePublicKey()
    {
        return $this->flutterwavePublicKey;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $flutterwavePublicKey  Undocumented variable
     *
     * @return  self
     */
    public function setFlutterwavePublicKey(string $flutterwavePublicKey)
    {
        $this->flutterwavePublicKey = $flutterwavePublicKey;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getFlutterwaveSecretKey()
    {
        return $this->flutterwaveSecretKey;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $flutterwaveSecretKey  Undocumented variable
     *
     * @return  self
     */
    public function setFlutterwaveSecretKey(string $flutterwaveSecretKey)
    {
        $this->flutterwaveSecretKey = $flutterwaveSecretKey;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getFlutterwaveEncKey()
    {
        return $this->flutterwaveEncKey;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $flutterwaveEncKey  Undocumented variable
     *
     * @return  self
     */
    public function setFlutterwaveEncKey(string $flutterwaveEncKey)
    {
        $this->flutterwaveEncKey = $flutterwaveEncKey;

        return $this;
    }
}
