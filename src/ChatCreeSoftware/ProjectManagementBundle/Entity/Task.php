<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatCreeSoftware\ProjectManagementBundle\Entity\Task
 */
class Task
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var date $target
     */
    private $target;

    /**
     * @var date $finalize
     */
    private $finalize;


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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set target
     *
     * @param date $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Get target
     *
     * @return date 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set finalize
     *
     * @param date $finalize
     */
    public function setFinalize($finalize)
    {
        $this->finalize = $finalize;
    }

    /**
     * Get finalize
     *
     * @return date 
     */
    public function getFinalize()
    {
        return $this->finalize;
    }
    /**
     * @var string $name
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Project
     */
    private $project;


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
