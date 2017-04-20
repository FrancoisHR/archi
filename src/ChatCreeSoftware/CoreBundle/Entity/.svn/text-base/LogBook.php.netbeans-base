<?php

namespace ChatCreeSoftware\CoreBundle\Entity;
use ChatCreeSoftware\CoreBundle\Entity\Project,
    ChatCreeSoftware\CoreBundle\Entity\Flags,
    ChatCreeSoftware\CoreBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatCreeSoftware\ProjectManagementBundle\Entity\LogBook
 */
class LogBook
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var date $date
     */
    private $date;

    /**
     * @var text $texte
     */
    private $texte;

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Project
     */
    private $project;

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\User
     */
    private $user;

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    private $logType;
    
    /**
     * @var string
     */
    private $ip;

    /**
     * @var boolean
     */
    private $locked;

    public function __construct( Project $project, Flags $flag, User $user, $locked ){
        $this->date = new \DateTime("now");
        $this->project = $project;
        $this->user = $user;
        $this->logType = $flag;
        $this->locked = $locked;
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
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set texte
     *
     * @param text $texte
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;
    }

    /**
     * Get texte
     *
     * @return text 
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set project
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Project $project
     */
    public function setProject( Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get project
     *
     * @return ChatCreeSoftware\CoreBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set user
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\User $user
     */
    public function setUser( User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return ChatCreeSoftware\CoreBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set logType
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Flags $logType
     */
    public function setLogType( Flags $logType)
    {
        $this->logType = $logType;
    }

    /**
     * Get logType
     *
     * @return ChatCreeSoftware\CoreBundle\Entity\Flags 
     */
    public function getLogType()
    {
        return $this->logType;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return LogBook
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return LogBook
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }
}
