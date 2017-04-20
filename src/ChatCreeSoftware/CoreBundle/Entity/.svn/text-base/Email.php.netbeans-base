<?php

namespace ChatCreeSoftware\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ChatCreeSoftware\CoreBundle\Entity\Email
 */
class Email
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Adresse mail invalide")
     * @Assert\NotBlank( message="Remplissez l'adresse mail")
     */
    private $mail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $primaire;


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Set mail
     *
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get mail
     *
     * @return string $mail
     */
    public function getMail()
    {
        return $this->mail;
    }
    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\User $user
     */
    public function setUser(\ChatCreeSoftware\CoreBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return ChatCreeSoftware\CoreBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set primaire
     *
     * @param boolean $primaire
     */
    public function setPrimaire($primaire)
    {
        $this->primaire = $primaire;
    }

    /**
     * Get primaire
     *
     * @return boolean $primaire
     */
    public function getPrimaire()
    {
        return $this->primaire;
    }
}
