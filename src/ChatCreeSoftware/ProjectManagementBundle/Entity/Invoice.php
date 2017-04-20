<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatCreeSoftware\ProjectManagementBundle\Entity\Invoice
 */
class Invoice
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $number
     */
    private $number;

    /**
     * @var string $state
     */
    private $state;

    /**
     * @var date $date
     */
    private $date;

    /**
     * @var date $reminder
     */
    private $reminder;

    /**
     * @var date $paid
     */
    private $paid;

    /**
     * @var text $footer
     */
    private $footer;

    /**
     * @var text $termsConditions
     */
    private $termsConditions;

    /**
     * @var text $specialTermsConditions
     */
    private $specialTermsConditions;

    /**
     * @var float $invoiceRebate
     */
    private $invoiceRebate;

    /**
     * @var text $invoiceRebateText
     */
    private $invoiceRebateText;

    /**
     * @var boolean $vatExemption
     */
    private $vatExemption;

    /**
     * @var text $vatExemptionText
     */
    private $vatExemptionText;

    /**
     * @var ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem
     */
    private $items;

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Project
     */
    private $project;

    /**
     * @var ChatCreeSoftware\ProjectManagementBundle\Entity\Address
     */
    private $address;
    
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set number
     *
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
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
     * Set state
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set reminder
     *
     * @param date $reminder
     */
    public function setReminder($reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Get reminder
     *
     * @return date 
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * Set paid
     *
     * @param date $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * Get paid
     *
     * @return date 
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set footer
     *
     * @param text $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    /**
     * Get footer
     *
     * @return text 
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Set termsConditions
     *
     * @param text $termsConditions
     */
    public function setTermsConditions($termsConditions)
    {
        $this->termsConditions = $termsConditions;
    }

    /**
     * Get termsConditions
     *
     * @return text 
     */
    public function getTermsConditions()
    {
        return $this->termsConditions;
    }

    /**
     * Set specialTermsConditions
     *
     * @param text $specialTermsConditions
     */
    public function setSpecialTermsConditions($specialTermsConditions)
    {
        $this->specialTermsConditions = $specialTermsConditions;
    }

    /**
     * Get specialTermsConditions
     *
     * @return text 
     */
    public function getSpecialTermsConditions()
    {
        return $this->specialTermsConditions;
    }

    /**
     * Set invoiceRebate
     *
     * @param float $invoiceRebate
     */
    public function setInvoiceRebate($invoiceRebate)
    {
        $this->invoiceRebate = $invoiceRebate;
    }

    /**
     * Get invoiceRebate
     *
     * @return float 
     */
    public function getInvoiceRebate()
    {
        return $this->invoiceRebate;
    }

    /**
     * Set invoiceRebateText
     *
     * @param text $invoiceRebateText
     */
    public function setInvoiceRebateText($invoiceRebateText)
    {
        $this->invoiceRebateText = $invoiceRebateText;
    }

    /**
     * Get invoiceRebateText
     *
     * @return text 
     */
    public function getInvoiceRebateText()
    {
        return $this->invoiceRebateText;
    }

    /**
     * Set vatExemption
     *
     * @param boolean $vatExemption
     */
    public function setVatExemption($vatExemption)
    {
        $this->vatExemption = $vatExemption;
    }

    /**
     * Get vatExemption
     *
     * @return boolean 
     */
    public function getVatExemption()
    {
        return $this->vatExemption;
    }

    /**
     * Set vatExemptionText
     *
     * @param text $vatExemptionText
     */
    public function setVatExemptionText($vatExemptionText)
    {
        $this->vatExemptionText = $vatExemptionText;
    }

    /**
     * Get vatExemptionText
     *
     * @return text 
     */
    public function getVatExemptionText()
    {
        return $this->vatExemptionText;
    }

    /**
     * Add items
     *
     * @param ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem $items
     */
    public function addInvoiceItem(\ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem $items)
    {
        $this->items[] = $items;
    }

    /**
     * Get items
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set project
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Project $project
     */
    public function setProject(\ChatCreeSoftware\CoreBundle\Entity\Project $project)
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
     * Set address
     *
     * @param ChatCreeSoftware\ProjectManagementBundle\Entity\Address $address
     */
    public function setAddress(\ChatCreeSoftware\ProjectManagementBundle\Entity\Address $address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return ChatCreeSoftware\ProjectManagementBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add item
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem $item
     *
     * @return Invoice
     */
    public function addItem(\ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem $item
     */
    public function removeItem(\ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem $item)
    {
        $this->items->removeElement($item);
    }
}
