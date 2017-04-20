<?php

namespace ChatCreeSoftware\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatCreeSoftware\CoreBundle\Entity\Flags
 */
class Flags
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $flagType
     */
    private $flagType;

    /**
     * @var string $flagLabel
     */
    private $flagLabel;


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
     * Set flagType
     *
     * @param string $flagType
     */
    public function setFlagType($flagType)
    {
        $this->flagType = $flagType;
    }

    /**
     * Get flagType
     *
     * @return string 
     */
    public function getFlagType()
    {
        return $this->flagType;
    }

    /**
     * Set flagLabel
     *
     * @param string $flagLabel
     */
    public function setFlagLabel($flagLabel)
    {
        $this->flagLabel = $flagLabel;
    }

    /**
     * Get flagLabel
     *
     * @return string 
     */
    public function getFlagLabel()
    {
        return $this->flagLabel;
    }
    /**
     * @var string $flagExtra
     */
    private $flagExtra;


    /**
     * Set flagExtra
     *
     * @param string $flagExtra
     */
    public function setFlagExtra($flagExtra)
    {
        $this->flagExtra = $flagExtra;
    }

    /**
     * Get flagExtra
     *
     * @return string 
     */
    public function getFlagExtra()
    {
        return $this->flagExtra;
    }
    /**
     * @var string $flagAlt
     */
    private $flagAlt;

    /**
     * @var string $flagImage
     */
    private $flagImage;


    /**
     * Set flagAlt
     *
     * @param string $flagAlt
     */
    public function setFlagAlt($flagAlt)
    {
        $this->flagAlt = $flagAlt;
    }

    /**
     * Get flagAlt
     *
     * @return string 
     */
    public function getFlagAlt()
    {
        return $this->flagAlt;
    }

    /**
     * Set flagImage
     *
     * @param string $flagImage
     */
    public function setFlagImage($flagImage)
    {
        $this->flagImage = $flagImage;
    }

    /**
     * Get flagImage
     *
     * @return string 
     */
    public function getFlagImage()
    {
        return $this->flagImage;
    }
}
