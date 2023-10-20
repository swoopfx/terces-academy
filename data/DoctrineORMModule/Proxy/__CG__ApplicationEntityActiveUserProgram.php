<?php

namespace DoctrineORMModule\Proxy\__CG__\Application\Entity;


/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class ActiveUserProgram extends \Application\Entity\ActiveUserProgram implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array<string, null> properties to be lazy loaded, indexed by property name
     */
    public static $lazyPropertiesNames = array (
);

    /**
     * @var array<string, mixed> default values of properties to be lazy loaded, with keys being the property names
     *
     * @see \Doctrine\Common\Proxy\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array (
);



    public function __construct(?\Closure $initializer = null, ?\Closure $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'id', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'user', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'program', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'isActive', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'createdOn', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'updatedOn', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'uuid', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'status', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'isInstallement', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'activeInstallment', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'paidInstallment'];
        }

        return ['__isInitialized__', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'id', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'user', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'program', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'isActive', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'createdOn', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'updatedOn', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'uuid', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'status', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'isInstallement', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'activeInstallment', '' . "\0" . 'Application\\Entity\\ActiveUserProgram' . "\0" . 'paidInstallment'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (ActiveUserProgram $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy::$lazyPropertiesDefaults as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load(): void
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized(): bool
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized): void
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null): void
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer(): ?\Closure
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null): void
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner(): ?\Closure
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @deprecated no longer in use - generated code now relies on internal components rather than generated public API
     * @static
     */
    public function __getLazyProperties(): array
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUser', []);

        return parent::getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(\Authentication\Entity\User $user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', [$user]);

        return parent::setUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function getProgram()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProgram', []);

        return parent::getProgram();
    }

    /**
     * {@inheritDoc}
     */
    public function setProgram(\Application\Entity\Programs $program)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProgram', [$program]);

        return parent::setProgram($program);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsActive()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsActive', []);

        return parent::getIsActive();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsActive(bool $isActive)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsActive', [$isActive]);

        return parent::setIsActive($isActive);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedOn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedOn', []);

        return parent::getCreatedOn();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedOn(\Datetime $createdOn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedOn', [$createdOn]);

        return parent::setCreatedOn($createdOn);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedOn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedOn', []);

        return parent::getUpdatedOn();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedOn(\Datetime $updatedOn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedOn', [$updatedOn]);

        return parent::setUpdatedOn($updatedOn);
    }

    /**
     * {@inheritDoc}
     */
    public function getUuid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUuid', []);

        return parent::getUuid();
    }

    /**
     * {@inheritDoc}
     */
    public function setUuid(string $uuid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUuid', [$uuid]);

        return parent::setUuid($uuid);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', []);

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus(\Application\Entity\ActiveUserProgramStatus $status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', [$status]);

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function setActiveInstallment(\Application\Entity\Installement $activeInstallment)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActiveInstallment', [$activeInstallment]);

        return parent::setActiveInstallment($activeInstallment);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsInstallement()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsInstallement', []);

        return parent::getIsInstallement();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsInstallement(bool $isInstallement)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsInstallement', [$isInstallement]);

        return parent::setIsInstallement($isInstallement);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaidInstallment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPaidInstallment', []);

        return parent::getPaidInstallment();
    }

    /**
     * {@inheritDoc}
     */
    public function setPaidInstallment(\Application\Entity\Installement $paidInstallment)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPaidInstallment', [$paidInstallment]);

        return parent::setPaidInstallment($paidInstallment);
    }

    /**
     * {@inheritDoc}
     */
    public function getActiveInstallment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getActiveInstallment', []);

        return parent::getActiveInstallment();
    }

}
