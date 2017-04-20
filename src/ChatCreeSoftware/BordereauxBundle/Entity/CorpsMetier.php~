<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * CorpsMetier
 */
class CorpsMetier
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
    private $sections;

    /**
     * @var \ChatCreeSoftware\BordereauxBundle\Entity\Librairie
     */
    private $librairie;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sections = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return CorpsMetier
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
     * @return CorpsMetier
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
     * Add section
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Section $section
     *
     * @return CorpsMetier
     */
    public function addSection(\ChatCreeSoftware\BordereauxBundle\Entity\Section $section)
    {
        $this->sections[] = $section;

        return $this;
    }

    /**
     * Remove section
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Section $section
     */
    public function removeSection(\ChatCreeSoftware\BordereauxBundle\Entity\Section $section)
    {
        $this->sections->removeElement($section);
    }

    /**
     * Get sections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Set librairie
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Librairie $librairie
     *
     * @return CorpsMetier
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
}
