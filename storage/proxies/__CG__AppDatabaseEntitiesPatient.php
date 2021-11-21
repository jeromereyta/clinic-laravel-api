<?php

namespace DoctrineProxies\__CG__\App\Database\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Patient extends \App\Database\Entities\Patient implements \Doctrine\ORM\Proxy\Proxy
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
  'createdAt' => NULL,
  'updatedAt' => NULL,
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
        unset($this->createdAt, $this->updatedAt);

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }

    /**
     * 
     * @param string $name
     */
    public function __get($name)
    {
        if (\array_key_exists($name, self::$lazyPropertiesNames)) {
            $this->__initializer__ && $this->__initializer__->__invoke($this, '__get', [$name]);
            return $this->$name;
        }

        trigger_error(sprintf('Undefined property: %s::$%s', __CLASS__, $name), E_USER_NOTICE);

    }

    /**
     * 
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        if (\array_key_exists($name, self::$lazyPropertiesNames)) {
            $this->__initializer__ && $this->__initializer__->__invoke($this, '__set', [$name, $value]);

            $this->$name = $value;

            return;
        }

        $this->$name = $value;
    }

    /**
     * 
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        if (\array_key_exists($name, self::$lazyPropertiesNames)) {
            $this->__initializer__ && $this->__initializer__->__invoke($this, '__isset', [$name]);

            return isset($this->$name);
        }

        return false;
    }

    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'createdAt', 'updatedAt', 'createdBy', 'patientVisits', 'updatedBy', 'active', 'age', 'barangay', 'birthDate', 'city', 'civilStatus', 'country', 'createdById', 'email', 'gender', 'id', 'name', 'patientCode', 'phoneNumber', 'profilePicture', 'province', 'streetAddress', 'updatedById'];
        }

        return ['__isInitialized__', 'createdBy', 'patientVisits', 'updatedBy', 'active', 'age', 'barangay', 'birthDate', 'city', 'civilStatus', 'country', 'createdById', 'email', 'gender', 'id', 'name', 'patientCode', 'phoneNumber', 'profilePicture', 'province', 'streetAddress', 'updatedById'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Patient $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy::$lazyPropertiesDefaults as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

            unset($this->createdAt, $this->updatedAt);
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
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @deprecated no longer in use - generated code now relies on internal components rather than generated public API
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function isActive(): bool
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isActive', []);

        return parent::isActive();
    }

    /**
     * {@inheritDoc}
     */
    public function getAge(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAge', []);

        return parent::getAge();
    }

    /**
     * {@inheritDoc}
     */
    public function getBirthDate(): \DateTimeInterface
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBirthDate', []);

        return parent::getBirthDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getCivilStatus(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCivilStatus', []);

        return parent::getCivilStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt(): \DateTimeInterface
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedAt', []);

        return parent::getCreatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedById(): int
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedById', []);

        return parent::getCreatedById();
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmail', []);

        return parent::getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function getGender(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGender', []);

        return parent::getGender();
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', []);

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function getPatientCode(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPatientCode', []);

        return parent::getPatientCode();
    }

    /**
     * {@inheritDoc}
     */
    public function getPatientVisits(): \Doctrine\ORM\PersistentCollection
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPatientVisits', []);

        return parent::getPatientVisits();
    }

    /**
     * {@inheritDoc}
     */
    public function getPhoneNumber(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPhoneNumber', []);

        return parent::getPhoneNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt(): \DateTimeInterface
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAt', []);

        return parent::getUpdatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedById(): ?int
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedById', []);

        return parent::getUpdatedById();
    }

    /**
     * {@inheritDoc}
     */
    public function setActive(bool $active): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActive', [$active]);

        parent::setActive($active);
    }

    /**
     * {@inheritDoc}
     */
    public function setAge(string $age): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAge', [$age]);

        parent::setAge($age);
    }

    /**
     * {@inheritDoc}
     */
    public function setBirthDate(\DateTimeInterface $birthDate): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBirthDate', [$birthDate]);

        parent::setBirthDate($birthDate);
    }

    /**
     * {@inheritDoc}
     */
    public function setCivilStatus(string $civilStatus): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCivilStatus', [$civilStatus]);

        parent::setCivilStatus($civilStatus);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedAt', [$createdAt]);

        return parent::setCreatedAt($createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedBy(\App\Database\Entities\UserGuest $user): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedBy', [$user]);

        return parent::setCreatedBy($user);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail(string $email): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmail', [$email]);

        return parent::setEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function setGender(string $gender): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGender', [$gender]);

        return parent::setGender($gender);
    }

    /**
     * {@inheritDoc}
     */
    public function setName(string $name): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', [$name]);

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getBarangay(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBarangay', []);

        return parent::getBarangay();
    }

    /**
     * {@inheritDoc}
     */
    public function setBarangay(string $barangay): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBarangay', [$barangay]);

        return parent::setBarangay($barangay);
    }

    /**
     * {@inheritDoc}
     */
    public function getCity(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCity', []);

        return parent::getCity();
    }

    /**
     * {@inheritDoc}
     */
    public function setCity(string $city): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCity', [$city]);

        return parent::setCity($city);
    }

    /**
     * {@inheritDoc}
     */
    public function getCountry(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCountry', []);

        return parent::getCountry();
    }

    /**
     * {@inheritDoc}
     */
    public function setCountry(string $country): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCountry', [$country]);

        return parent::setCountry($country);
    }

    /**
     * {@inheritDoc}
     */
    public function getProfilePicture(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProfilePicture', []);

        return parent::getProfilePicture();
    }

    /**
     * {@inheritDoc}
     */
    public function setProfilePicture(string $profilePicture): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProfilePicture', [$profilePicture]);

        return parent::setProfilePicture($profilePicture);
    }

    /**
     * {@inheritDoc}
     */
    public function getProvince(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProvince', []);

        return parent::getProvince();
    }

    /**
     * {@inheritDoc}
     */
    public function setProvince(string $province): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProvince', [$province]);

        return parent::setProvince($province);
    }

    /**
     * {@inheritDoc}
     */
    public function getStreetAddress(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStreetAddress', []);

        return parent::getStreetAddress();
    }

    /**
     * {@inheritDoc}
     */
    public function setStreetAddress(string $streetAddress): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStreetAddress', [$streetAddress]);

        return parent::setStreetAddress($streetAddress);
    }

    /**
     * {@inheritDoc}
     */
    public function setPatientCode(string $patientCode): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPatientCode', [$patientCode]);

        return parent::setPatientCode($patientCode);
    }

    /**
     * {@inheritDoc}
     */
    public function setPhoneNumber(string $phoneNumber): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPhoneNumber', [$phoneNumber]);

        return parent::setPhoneNumber($phoneNumber);
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedAt', [$updatedAt]);

        return parent::setUpdatedAt($updatedAt);
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedBy(\App\Database\Entities\UserGuest $user = NULL): \App\Database\Entities\Patient
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedBy', [$user]);

        return parent::setUpdatedBy($user);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAtAsString(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedAtAsString', []);

        return parent::getCreatedAtAsString();
    }

    /**
     * {@inheritDoc}
     */
    public function getRules(): array
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRules', []);

        return parent::getRules();
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAtAsString(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAtAsString', []);

        return parent::getUpdatedAtAsString();
    }

    /**
     * {@inheritDoc}
     */
    public function getValidationFailedException(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getValidationFailedException', []);

        return parent::getValidationFailedException();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', []);

        return parent::toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function __call(string $method, array $parameters)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__call', [$method, $parameters]);

        return parent::__call($method, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function fill(array $data): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'fill', [$data]);

        parent::fill($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getFillableProperties(): array
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFillableProperties', []);

        return parent::getFillableProperties();
    }

    /**
     * {@inheritDoc}
     */
    public function getValidatableProperties(): array
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getValidatableProperties', []);

        return parent::getValidatableProperties();
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): array
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'jsonSerialize', []);

        return parent::jsonSerialize();
    }

    /**
     * {@inheritDoc}
     */
    public function toJson(): string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toJson', []);

        return parent::toJson();
    }

    /**
     * {@inheritDoc}
     */
    public function toXml(string $rootNode = NULL): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toXml', [$rootNode]);

        return parent::toXml($rootNode);
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

}