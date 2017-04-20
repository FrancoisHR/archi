<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * InfoSupplementaire
 */
class InfoSupplementaire
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $information;

    /**
     * @var string
     */
    private $valeur;

    /**
     * @var \ChatCreeSoftware\BordereauxBundle\Entity\Prestation
     */
    private $prestation;


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
     * Set information
     *
     * @param string $information
     *
     * @return InfoSupplementaire
     */
    public function setInformation($information)
    {
        $this->information = $information;

        return $this;
    }

    /**
     * Get information
     *
     * @return string
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Set valeur
     *
     * @param string $valeur
     *
     * @return InfoSupplementaire
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set prestation
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Prestation $prestation
     *
     * @return InfoSupplementaire
     */
    public function setPrestation(\ChatCreeSoftware\BordereauxBundle\Entity\Prestation $prestation = null)
    {
        $this->prestation = $prestation;

        return $this;
    }

    /**
     * Get prestation
     *
     * @return \ChatCreeSoftware\BordereauxBundle\Entity\Prestation
     */
    public function getPrestation()
    {
        return $this->prestation;
    }

    public function equals(InfoSupplementaire $info ){
        if( $info )
            return $this->getInformation() == $info->getInformation() &&
               $this->getValeur() == $info->getValeur();
        else
            return false;
    }    
    
}
