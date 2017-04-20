<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Entity;

use ChatCreeSoftware\CoreBundle\Entity\Flags;
use ChatCreeSoftware\CoreBundle\Entity\Project;
use Doctrine\ORM\Mapping as ORM;

/**
 * ChatCreeSoftware\ProjectManagementBundle\Entity\Address
 */
class Address
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $street1
     */
    private $street1;

    /**
     * @var string $street2
     */
    private $street2;

    /**
     * @var string $street3
     */
    private $street3;

    /**
     * @var string $city
     */
    private $city;

    /**
     * @var string $zipCode
     */
    private $zipCode;

    /**
     * @var string $country
     */
    private $country;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Project
     */
    private $project;


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
     * Set street1
     *
     * @param string $street1
     */
    public function setStreet1($street1)
    {
        $this->street1 = $street1;
    }

    /**
     * Get street1
     *
     * @return string 
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * Set street2
     *
     * @param string $street2
     */
    public function setStreet2($street2)
    {
        $this->street2 = $street2;
    }

    /**
     * Get street2
     *
     * @return string 
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * Set street3
     *
     * @param string $street3
     */
    public function setStreet3($street3)
    {
        $this->street3 = $street3;
    }

    /**
     * Get street3
     *
     * @return string 
     */
    public function getStreet3()
    {
        return $this->street3;
    }

    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * Get zipCode
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set project
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Project $project
     */
    public function setProject( Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get project
     *
     * @return ChatCreeSoftware\CoreBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }
    /**
     * @var string $company
     */
    private $company;

    /**
     * @var string $firstname
     */
    private $firstname;

    /**
     * @var string $lastname
     */
    private $lastname;


    /**
     * Set company
     *
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    /**
     * @var string $title
     */
    private $title;


    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    private $addressType;


    /**
     * Set addressType
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Flags $addressType
     */
    public function setAddressType( Flags $addressType)
    {
        $this->addressType = $addressType;
    }

    /**
     * Get addressType
     *
     * @return ChatCreeSoftware\CoreBundle\Entity\Flags 
     */
    public function getAddressType()
    {
        return $this->addressType;
    }
    /**
     * @var string $vatNumber
     */
    private $vatNumber;


    /**
     * Set vatNumber
     *
     * @param string $vatNumber
     */
    public function setVatNumber($vatNumber)
    {
        $this->vatNumber = $vatNumber;
    }

    /**
     * Get vatNumber
     *
     * @return string 
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $invoices;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add invoice
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Invoice $invoice
     *
     * @return Address
     */
    public function addInvoice(\ChatCreeSoftware\ProjectManagementBundle\Entity\Invoice $invoice)
    {
        $this->invoices[] = $invoice;

        return $this;
    }

    /**
     * Remove invoice
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Invoice $invoice
     */
    public function removeInvoice(\ChatCreeSoftware\ProjectManagementBundle\Entity\Invoice $invoice)
    {
        $this->invoices->removeElement($invoice);
    }

    /**
     * Get invoices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }
}
