<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatCreeSoftware\ProjectManagementBundle\Entity\Invoicing
 */
class Invoicing
{
    /**
     * @var integer $id
     */
    private $id;
   
    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Project
     */
    private $project;
    
    /**
     * @var string $etape
     */
    private $etape;

    /**
     * @var float $amount
     */
    private $amount;

    /**
     * @var date $invoiced
     */
    private $invoiced;

    /**
     * @var date $reminder
     */
    private $reminder;

    /**
     * @var date $paid
     */
    private $paid;

    
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
     * Set etape
     *
     * @param string $etape
     */
    public function setEtape($etape)
    {
        $this->etape = $etape;
    }

    /**
     * Get etape
     *
     * @return string 
     */
    public function getEtape()
    {
        return $this->etape;
    }

    /**
     * Set amount
     *
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
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
     * Set invoiced
     *
     * @param date $invoiced
     */
    public function setInvoiced($invoiced)
    {
        $this->invoiced = $invoiced;
    }

    /**
     * Get invoiced
     *
     * @return date 
     */
    public function getInvoiced()
    {
        return $this->invoiced;
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
     * @var ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem
     */
    private $item;


    /**
     * Set item
     *
     * @param ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem $item
     */
    public function setItem(\ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem $item)
    {
        $this->item = $item;
    }

    /**
     * Get item
     *
     * @return ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceItem 
     */
    public function getItem()
    {
        return $this->item;
    }
    /**
     * @var string
     */
    private $type;


    /**
     * Set type
     *
     * @param string $type
     *
     * @return Invoicing
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
}
