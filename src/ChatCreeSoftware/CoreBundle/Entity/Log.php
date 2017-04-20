<?php

namespace ChatCreeSoftware\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatCreeSoftware\CoreBundle\Entity\Log
 */
class Log
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var datetime $timestamp
     */
    private $timestamp;

    /**
     * @var string $action
     */
    private $action;

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\User
     */
    private $user;


    public function __construct( $action ) {
        $this->timestamp = new \DateTime("now");
        $this->action = $action;
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
     * Set timestamp
     *
     * @param datetime $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Get timestamp
     *
     * @return datetime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set action
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
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
     * @var string $ip
     */
    private $ip;

    /**
     * @var string $detail
     */
    private $detail;


    /**
     * Set ip
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
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
     * Set detail
     *
     * @param string $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }

    /**
     * Get detail
     *
     * @return string 
     */
    public function getDetail()
    {
        return $this->detail;
    }
}
