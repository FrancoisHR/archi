<?php

namespace ChatCreeSoftware\CoreBundle\Entity;

/**
 * Country
 */
class Country
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $languageCode;

    /**
     * @var string
     */
    private $phoneCode;

    /**
     * @var string
     */
    private $phoneFormat;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $phoneNumbers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phoneNumbers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set languageCode
     *
     * @param string $languageCode
     *
     * @return Country
     */
    public function setLanguageCode($languageCode)
    {
        $this->languageCode = $languageCode;

        return $this;
    }

    /**
     * Get languageCode
     *
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    /**
     * Set phoneCode
     *
     * @param string $phoneCode
     *
     * @return Country
     */
    public function setPhoneCode($phoneCode)
    {
        $this->phoneCode = $phoneCode;

        return $this;
    }

    /**
     * Get phoneCode
     *
     * @return string
     */
    public function getPhoneCode()
    {
        return $this->phoneCode;
    }

    /**
     * Set phoneFormat
     *
     * @param string $phoneFormat
     *
     * @return Country
     */
    public function setPhoneFormat($phoneFormat)
    {
        $this->phoneFormat = $phoneFormat;

        return $this;
    }

    /**
     * Get phoneFormat
     *
     * @return string
     */
    public function getPhoneFormat()
    {
        return $this->phoneFormat;
    }

    /**
     * Add phoneNumber
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Phone $phoneNumber
     *
     * @return Country
     */
    public function addPhoneNumber(\ChatCreeSoftware\CoreBundle\Entity\Phone $phoneNumber)
    {
        $this->phoneNumbers[] = $phoneNumber;

        return $this;
    }

    /**
     * Remove phoneNumber
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Phone $phoneNumber
     */
    public function removePhoneNumber(\ChatCreeSoftware\CoreBundle\Entity\Phone $phoneNumber)
    {
        $this->phoneNumbers->removeElement($phoneNumber);
    }

    /**
     * Get phoneNumbers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }
}
