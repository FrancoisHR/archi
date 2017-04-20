<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * Parametre
 */
class Parametre
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $ordre;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $titre;

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
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Parametre
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return Parametre
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Parametre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set prestation
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Prestation $prestation
     *
     * @return Parametre
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

    public function equals( Parametre $param ){
        if( $param )
            return $this->getOrdre() == $param->getOrdre() &&
               $this->getNumero() == $param->getNumero() &&
               $this->getTitre() == $param->getTitre();
        else
            return false;
    }    
}
