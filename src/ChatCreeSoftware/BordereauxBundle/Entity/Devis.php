<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * Devis
 */
class Devis
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $version;

    /**
     * @var \DateTime
     */
    private $ouverture;

    /**
     * @var \DateTime
     */
    private $envoi;

    /**
     * @var \DateTime
     */
    private $depot;

    /**
     * @var \DateTime
     */
    private $cloture;

    /**
     * @var string
     */
    private $commentaire;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lignes;

    /**
     * @var \ChatCreeSoftware\BordereauxBundle\Entity\Bordereau
     */
    private $bordereau;

    /**
     * @var \ChatCreeSoftware\CoreBundle\Entity\User
     */
    private $soumissionnaire;
    
    /**
     * @var \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    private $etat;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lignes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set version
     *
     * @param integer $version
     *
     * @return Devis
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Add ligne
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\LigneDevis $ligne
     *
     * @return Devis
     */
    public function addLigne(\ChatCreeSoftware\BordereauxBundle\Entity\LigneDevis $ligne)
    {
        $this->lignes[] = $ligne;

        return $this;
    }

    /**
     * Remove ligne
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\LigneDevis $ligne
     */
    public function removeLigne(\ChatCreeSoftware\BordereauxBundle\Entity\LigneDevis $ligne)
    {
        $this->lignes->removeElement($ligne);
    }

    /**
     * Get lignes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignes()
    {
        return $this->lignes;
    }

    /**
     * Set bordereau
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereau
     *
     * @return Devis
     */
    public function setBordereau(\ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereau = null)
    {
        $this->bordereau = $bordereau;

        return $this;
    }

    /**
     * Get bordereau
     *
     * @return \ChatCreeSoftware\BordereauxBundle\Entity\Bordereau
     */
    public function getBordereau()
    {
        return $this->bordereau;
    }

    /**
     * Set soumissionnaire
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\User $soumissionnaire
     *
     * @return Devis
     */
    public function setSoumissionnaire(\ChatCreeSoftware\CoreBundle\Entity\User $soumissionnaire = null)
    {
        $this->soumissionnaire = $soumissionnaire;

        return $this;
    }

    /**
     * Get soumissionnaire
     *
     * @return \ChatCreeSoftware\CoreBundle\Entity\User
     */
    public function getSoumissionnaire()
    {
        return $this->soumissionnaire;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Devis
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

    /**
     * Set etat
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Flags $etat
     *
     * @return Devis
     */
    public function setEtat(\ChatCreeSoftware\CoreBundle\Entity\Flags $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set ouverture
     *
     * @param \DateTime $ouverture
     *
     * @return Devis
     */
    public function setOuverture($ouverture)
    {
        $this->ouverture = $ouverture;

        return $this;
    }

    /**
     * Get ouverture
     *
     * @return \DateTime
     */
    public function getOuverture()
    {
        return $this->ouverture;
    }

    /**
     * Set depot
     *
     * @param \DateTime $depot
     *
     * @return Devis
     */
    public function setDepot($depot)
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * Get depot
     *
     * @return \DateTime
     */
    public function getDepot()
    {
        return $this->depot;
    }

    /**
     * Set cloture
     *
     * @param \DateTime $cloture
     *
     * @return Devis
     */
    public function setCloture($cloture)
    {
        $this->cloture = $cloture;

        return $this;
    }

    /**
     * Get cloture
     *
     * @return \DateTime
     */
    public function getCloture()
    {
        return $this->cloture;
    }

    /**
     * Set envoi
     *
     * @param \DateTime $envoi
     *
     * @return Devis
     */
    public function setEnvoi($envoi)
    {
        $this->envoi = $envoi;

        return $this;
    }

    /**
     * Get envoi
     *
     * @return \DateTime
     */
    public function getEnvoi()
    {
        return $this->envoi;
    }
}
