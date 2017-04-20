<?php

namespace ChatCreeSoftware\FileserverBundle\Entity;

/**
 * FileLink
 */
class FileLink
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \ChatCreeSoftware\CoreBundle\Entity\User
     */
    private $user;

    /**
     * @var \ChatCreeSoftware\CoreBundle\Entity\Project
     */
    private $project;

    public function __construct( \ChatCreeSoftware\CoreBundle\Entity\User $user, \ChatCreeSoftware\CoreBundle\Entity\Project $project, $file){
        
        $this->user = $user;
        $this->project = $project;
        $this->file = $file;
        $this->date = new \DateTime("now");
        
        // Compute token
        $this->token = hash( "sha256", $user->getLogin() . $project->getProjectName() . $file . $this->date->format("ddmmYYYY"));
        
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
     * Set file
     *
     * @param string $file
     *
     * @return FileLink
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return FileLink
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FileLink
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
     * Set user
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\User $user
     *
     * @return FileLink
     */
    public function setUser(\ChatCreeSoftware\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ChatCreeSoftware\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set project
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Project $project
     *
     * @return FileLink
     */
    public function setProject(\ChatCreeSoftware\CoreBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \ChatCreeSoftware\CoreBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }
}
