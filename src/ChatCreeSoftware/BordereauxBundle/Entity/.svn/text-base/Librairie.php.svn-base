<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * Librairie
 */
class Librairie
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $auteur;

    /**
     * @var string
     */
    private $prefixe;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $versionDtd;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $corpsMetiers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->corpsMetiers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Librairie
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
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Librairie
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set prefixe
     *
     * @param string $prefixe
     *
     * @return Librairie
     */
    public function setPrefixe($prefixe)
    {
        $this->prefixe = $prefixe;

        return $this;
    }

    /**
     * Get prefixe
     *
     * @return string
     */
    public function getPrefixe()
    {
        return $this->prefixe;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Librairie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Librairie
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set versionDtd
     *
     * @param string $versionDtd
     *
     * @return Librairie
     */
    public function setVersionDtd($versionDtd)
    {
        $this->versionDtd = $versionDtd;

        return $this;
    }

    /**
     * Get versionDtd
     *
     * @return string
     */
    public function getVersionDtd()
    {
        return $this->versionDtd;
    }

    /**
     * Add corpsMetier
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $corpsMetier
     *
     * @return Librairie
     */
    public function addCorpsMetier(\ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $corpsMetier)
    {
        $this->corpsMetiers[] = $corpsMetier;

        return $this;
    }

    /**
     * Remove corpsMetier
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $corpsMetier
     */
    public function removeCorpsMetier(\ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $corpsMetier)
    {
        $this->corpsMetiers->removeElement($corpsMetier);
    }

    /**
     * Get corpsMetiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCorpsMetiers()
    {
        return $this->corpsMetiers;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $projet;


    /**
     * Add projet
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $projet
     *
     * @return Librairie
     */
    public function addProjet(\ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $projet)
    {
        $this->projet[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $projet
     */
    public function removeProjet(\ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $projet)
    {
        $this->projet->removeElement($projet);
    }

    /**
     * Get projet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjet()
    {
        return $this->projet;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $fichiers;


    /**
     * Add fichier
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Fichier $fichier
     *
     * @return Librairie
     */
    public function addFichier(\ChatCreeSoftware\BordereauxBundle\Entity\Fichier $fichier)
    {
        $this->fichiers[] = $fichier;

        return $this;
    }

    /**
     * Remove fichier
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Fichier $fichier
     */
    public function removeFichier(\ChatCreeSoftware\BordereauxBundle\Entity\Fichier $fichier)
    {
        $this->fichiers->removeElement($fichier);
    }

    /**
     * Get fichiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFichiers()
    {
        return $this->fichiers;
    }
}
