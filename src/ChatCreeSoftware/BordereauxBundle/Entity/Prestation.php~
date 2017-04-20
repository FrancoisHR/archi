<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * Prestation
 */
class Prestation
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
    private $numeroComplet;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $indiceRevision;

    /**
     * @var \DateTime
     */
    private $dateRevision;

    /**
     * @var string
     */
    private $unite;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $parametres;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $infoSupplementaires;

    /**
     * @var \ChatCreeSoftware\BordereauxBundle\Entity\Section
     */
    private $section;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parametres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->infoSupplementaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Prestation
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
     * Set numeroComplet
     *
     * @param string $numeroComplet
     *
     * @return Prestation
     */
    public function setNumeroComplet($numeroComplet)
    {
        $this->numeroComplet = $numeroComplet;

        return $this;
    }

    /**
     * Get numeroComplet
     *
     * @return string
     */
    public function getNumeroComplet()
    {
        return $this->numeroComplet;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Prestation
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set indiceRevision
     *
     * @param string $indiceRevision
     *
     * @return Prestation
     */
    public function setIndiceRevision($indiceRevision)
    {
        $this->indiceRevision = $indiceRevision;

        return $this;
    }

    /**
     * Get indiceRevision
     *
     * @return string
     */
    public function getIndiceRevision()
    {
        return $this->indiceRevision;
    }

    /**
     * Set dateRevision
     *
     * @param \DateTime $dateRevision
     *
     * @return Prestation
     */
    public function setDateRevision($dateRevision)
    {
        $this->dateRevision = $dateRevision;

        return $this;
    }

    /**
     * Get dateRevision
     *
     * @return \DateTime
     */
    public function getDateRevision()
    {
        return $this->dateRevision;
    }

    /**
     * Set unite
     *
     * @param string $unite
     *
     * @return Prestation
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;

        return $this;
    }

    /**
     * Get unite
     *
     * @return string
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Prestation
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
     * Set description
     *
     * @param string $description
     *
     * @return Prestation
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
     * Add parametre
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Parametre $parametre
     *
     * @return Prestation
     */
    public function addParametre(\ChatCreeSoftware\BordereauxBundle\Entity\Parametre $parametre)
    {
        $this->parametres[] = $parametre;

        return $this;
    }

    /**
     * Remove parametre
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Parametre $parametre
     */
    public function removeParametre(\ChatCreeSoftware\BordereauxBundle\Entity\Parametre $parametre)
    {
        $this->parametres->removeElement($parametre);
    }

    /**
     * Get parametres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParametres()
    {
        return $this->parametres;
    }
    
    /**
     * Check if collection already has a Parametre
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Parametre $parametre
     *
     * @return Bool
     */
    public function hasParametre(\ChatCreeSoftware\BordereauxBundle\Entity\Parametre $parametre)
    {
        foreach( $this->getParametres() as $p ){
            if( $p->equals( $parametre ) ){
                return true;
            }
        }
        return false;
    }

    /**
     * Add question
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Question $question
     *
     * @return Prestation
     */
    public function addQuestion(\ChatCreeSoftware\BordereauxBundle\Entity\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Question $question
     */
    public function removeQuestion(\ChatCreeSoftware\BordereauxBundle\Entity\Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Check if collection already has a Question
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Question $question
     *
     * @return Bool
     */
    public function hasQuestion(\ChatCreeSoftware\BordereauxBundle\Entity\Question $question)
    {
        foreach( $this->getQuestions() as $q ){
            if( $q->equals( $question ) ){
                return true;
            }
        }
        return false;
    }    
    
    /**
     * Add infoSupplementaire
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\InfoSupplementaire $infoSupplementaire
     *
     * @return Prestation
     */
    public function addInfoSupplementaire(\ChatCreeSoftware\BordereauxBundle\Entity\InfoSupplementaire $infoSupplementaire)
    {
        $this->infoSupplementaires[] = $infoSupplementaire;

        return $this;
    }

    /**
     * Remove infoSupplementaire
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\InfoSupplementaire $infoSupplementaire
     */
    public function removeInfoSupplementaire(\ChatCreeSoftware\BordereauxBundle\Entity\InfoSupplementaire $infoSupplementaire)
    {
        $this->infoSupplementaires->removeElement($infoSupplementaire);
    }

    /**
     * Get infoSupplementaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInfoSupplementaires()
    {
        return $this->infoSupplementaires;
    }
    /**
     * Check if collection already has an InfoSUpplementaire
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\InfoSupplementaire $info
     *
     * @return Bool
     */
    public function hasInfoSupplementaire(\ChatCreeSoftware\BordereauxBundle\Entity\InfoSupplementaire $info)
    {
        foreach( $this->getInfoSupplementaires() as $i ){
            if( $i->equals( $info ) ){
                return true;
            }
        }
        return false;
    }    
        
    /**
     * Set section
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Section $section
     *
     * @return Prestation
     */
    public function setSection(\ChatCreeSoftware\BordereauxBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \ChatCreeSoftware\BordereauxBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lignes;


    /**
     * Add ligne
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Ligne $ligne
     *
     * @return Prestation
     */
    public function addLigne(\ChatCreeSoftware\BordereauxBundle\Entity\Ligne $ligne)
    {
        $this->lignes[] = $ligne;

        return $this;
    }

    /**
     * Remove ligne
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Ligne $ligne
     */
    public function removeLigne(\ChatCreeSoftware\BordereauxBundle\Entity\Ligne $ligne)
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
}
