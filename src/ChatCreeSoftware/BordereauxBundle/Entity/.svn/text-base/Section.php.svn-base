<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * Section
 */
class Section
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $prestations;

    /**
     * @var \ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier
     */
    private $corpsMetier;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->prestations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numero
     *
     * @param string $numero
     *
     * @return Section
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
     * @return Section
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
     * Add prestation
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Prestation $prestation
     *
     * @return Section
     */
    public function addPrestation(\ChatCreeSoftware\BordereauxBundle\Entity\Prestation $prestation)
    {
        $this->prestations[] = $prestation;

        return $this;
    }

    /**
     * Remove prestation
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Prestation $prestation
     */
    public function removePrestation(\ChatCreeSoftware\BordereauxBundle\Entity\Prestation $prestation)
    {
        $this->prestations->removeElement($prestation);
    }

    /**
     * Get prestations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrestations()
    {
        return $this->prestations;
    }

    /**
     * Set corpsMetier
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $corpsMetier
     *
     * @return Section
     */
    public function setCorpsMetier(\ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier $corpsMetier = null)
    {
        $this->corpsMetier = $corpsMetier;

        return $this;
    }

    /**
     * Get corpsMetier
     *
     * @return \ChatCreeSoftware\BordereauxBundle\Entity\CorpsMetier
     */
    public function getCorpsMetier()
    {
        return $this->corpsMetier;
    }
}
