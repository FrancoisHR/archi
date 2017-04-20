<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatCreeSoftware\ProjectManagementBundle\Entity\InvoiceNumbering
 */
class InvoiceNumbering
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $year
     */
    private $year;

    /**
     * @var integer $number
     */
    private $number;

    /**
     * @var ChatCreeSoftware\ProjectManagementBundle\Entity\User
     */
    private $user;


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
     * Set year
     *
     * @param string $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * Get year
     *
     * @return string 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set number
     *
     * @param integer $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }
    /**
     * @var integer
     */
    private $type;


    /**
     * Set type
     *
     * @param integer $type
     *
     * @return InvoiceNumbering
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
}
