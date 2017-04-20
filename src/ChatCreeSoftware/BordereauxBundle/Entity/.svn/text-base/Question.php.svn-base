<?php

namespace ChatCreeSoftware\BordereauxBundle\Entity;

/**
 * Question
 */
class Question
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $identifiant;

    /**
     * @var string
     */
    private $question;

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
     * Set identifiant
     *
     * @param string $identifiant
     *
     * @return Question
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    /**
     * Get identifiant
     *
     * @return string
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * Set question
     *
     * @param string $question
     *
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set prestation
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Prestation $prestation
     *
     * @return Question
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
    
    public function equals( Question $question ){
        if( $question )
            return $this->getIdentifiant() == $question->getIdentifiant() &&
               $this->getQuestion() == $question->getQuestion();
        else
            return false;
    }   
}
