<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * Fichier
 */
class Fichier
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
    private $numero;

    /**
     * @var integer
     */
    private $version;

    /**
     * @var string
     */
    private $fichier;

    /**
     * @var \ChatCreeSoftware\BordereauxBundle\Entity\Librairie
     */
    private $librairie;


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
     * @return Fichier
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
     * Set numero
     *
     * @param string $numero
     *
     * @return Fichier
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
     * Set version
     *
     * @param integer $version
     *
     * @return Fichier
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
     * Set fichier
     *
     * @param string $fichier
     *
     * @return Fichier
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * Get fichier
     *
     * @return string
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * Set librairie
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Librairie $librairie
     *
     * @return Fichier
     */
    public function setLibrairie(\ChatCreeSoftware\BordereauxBundle\Entity\Librairie $librairie = null)
    {
        $this->librairie = $librairie;

        return $this;
    }

    /**
     * Get librairie
     *
     * @return \ChatCreeSoftware\BordereauxBundle\Entity\Librairie
     */
    public function getLibrairie()
    {
        return $this->librairie;
    }
    /**
     * @var \DateTime
     */
    private $date;


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Fichier
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bordereaux;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bordereaux = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add bordereaux
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereaux
     *
     * @return Fichier
     */
    public function addBordereaux(\ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereaux)
    {
        $this->bordereaux[] = $bordereaux;

        return $this;
    }

    /**
     * Remove bordereaux
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereaux
     */
    public function removeBordereaux(\ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereaux)
    {
        $this->bordereaux->removeElement($bordereaux);
    }

    /**
     * Get bordereaux
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBordereaux()
    {
        return $this->bordereaux;
    }
}
