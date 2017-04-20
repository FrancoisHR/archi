<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * LigneDevis
 */
class LigneDevis
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $prixUnitaire;

    /**
     * @var string
     */
    private $commentaire;
    
    /**
     * @var \ChatCreeSoftware\BordereauxBundle\Entity\Devis
     */
    private $devis;

    /**
     * @var \ChatCreeSoftware\BordereauxBundle\Entity\Ligne
     */
    private $ligne;


    public function __construct( \ChatCreeSoftware\BordereauxBundle\Entity\Devis $devis, \ChatCreeSoftware\BordereauxBundle\Entity\Ligne $ligne ) {
        $this->devis = $devis;
        $this->ligne = $ligne;
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
     * Set devis
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Devis $devis
     *
     * @return LigneDevis
     */
    public function setDevis(\ChatCreeSoftware\BordereauxBundle\Entity\Devis $devis = null)
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * Get devis
     *
     * @return \ChatCreeSoftware\BordereauxBundle\Entity\Devis
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set ligne
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Ligne $ligne
     *
     * @return LigneDevis
     */
    public function setLigne(\ChatCreeSoftware\BordereauxBundle\Entity\Ligne $ligne = null)
    {
        $this->ligne = $ligne;

        return $this;
    }

    /**
     * Get ligne
     *
     * @return \ChatCreeSoftware\BordereauxBundle\Entity\Ligne
     */
    public function getLigne()
    {
        return $this->ligne;
    }

    /**
     * Set prixUnitaire
     *
     * @param float $prixUnitaire
     *
     * @return LigneDevis
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * Get prixUnitaire
     *
     * @return float
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return LigneDevis
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}
