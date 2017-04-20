<?php

namespace ChatCreeSoftware\CoreBundle\Entity;

/**
 * Phone
 */
class Phone
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $number;

    /**
     * @var \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    private $phoneType;

    /**
     * @var \ChatCreeSoftware\CoreBundle\Entity\Country
     */
    private $country;


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
     * Set number
     *
     * @param string $number
     *
     * @return Phone
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set phoneType
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Flags $phoneType
     *
     * @return Phone
     */
    public function setPhoneType(\ChatCreeSoftware\CoreBundle\Entity\Flags $phoneType = null)
    {
        $this->phoneType = $phoneType;

        return $this;
    }

    /**
     * Get phoneType
     *
     * @return \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    public function getPhoneType()
    {
        return $this->phoneType;
    }

    /**
     * Set country
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Country $country
     *
     * @return Phone
     */
    public function setCountry(\ChatCreeSoftware\CoreBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \ChatCreeSoftware\CoreBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }
}
