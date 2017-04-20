<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog
 */
class TimeLog
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
     * @var integer $hours
     */
    private $hours;

    /**
     * @var integer $minutes
     */
    private $minutes;

    /**
     * @var text $description
     */
    private $description;

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\User
     */
    private $user;

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Project
     */
    private $project;


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
     * Set hours
     *
     * @param integer $hours
     */
    public function setHours($hours)
    {
        $this->hours = $hours;
    }

    /**
     * Get hours
     *
     * @return integer 
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set minutes
     *
     * @param integer $minutes
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;
    }

    /**
     * Get minutes
     *
     * @return integer 
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

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
     * @return ChatCreeSoftware\CoreBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set project
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Project $project
     */
    public function setProject(\ChatCreeSoftware\CoreBundle\Entity\Project $project)
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
}
