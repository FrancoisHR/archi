<?php

namespace ChatCreeSoftware\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="CoreUser")
 */
class User implements UserInterface
{
    
    private static $role_array = array( 'Utilisateur' => 'ROLE_USER', 'Fournisseur' => 'ROLE_PROVIDER', 'Employé' => 'ROLE_EMPLOYEE', 'Admin' => 'ROLE_ADMIN');
    private static $reverse_role_array = array( 'ROLE_USER' => 'Utilisateur', 'ROLE_PROVIDER' => 'Fournisseur', 'ROLE_EMPLOYEE' => 'Employé', 'ROLE_ADMIN' => 'Admin');
    private static $title_array = array( '' => '', 'Monsieur' => 'Monsieur', 'Madame' => 'Madame', 'Mademoiselle' => 'Mademoiselle');

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank( message="Remplissez le nom")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank( message="Remplissez le login")
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="Remplissez le mot de passe")
     * @Assert\Length(min=6,max=50, minMessage="Mot de passe de {{ limit }} caracteres au moins", maxMessage="Votre mot de passe ne peut faire plus de {{ limit }} caractères.")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $role;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Email
     */
    private $emails;

    public function __construct()
    {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set login
     *
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Get login
     *
     * @return string $login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set role
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Get role
     *
     * @return string $role
     */
    public function getRole()
    {
        return $this->role;
    }
    
    public function getRoleLabel() {
        return self::$reverse_role_array[$this->role];
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
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
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }    
       
    /**
     * Add emails
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Email $emails
     */
    public function addEmails(\ChatCreeSoftware\CoreBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;
    }

    /**
     * Get emails
     *
     * @return Doctrine\Common\Collections\Collection $emails
     */
    public function getEmails()
    {
        return $this->emails;
    }    

    public static function getRolesArray() {
        return self::$role_array;
    }

    public static function getTitlesArray() {
        return self::$title_array;
    }
    
//*************************************************
    // UserInterface implementation
    
    public function equals( UserInterface $user ){
        return true;
    }
    
    public function eraseCredentials()
    {
        
    }
    
    public function getRoles()
    {
        return array( $this->role );
    }
    
    public function getSalt()
    {
        
    }
    
    public function getUsername()
    {
        return $this->login;
    }

    /**
     * @var ChatCreeSoftware\CoreBundle\Entity\Log
     */
    private $logs;


    /**
     * Add logs
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Log $logs
     */
    public function addLogs(\ChatCreeSoftware\CoreBundle\Entity\Log $logs)
    {
        $this->logs[] = $logs;
    }

    /**
     * Get logs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLogs()
    {
        return $this->logs;
    }
    /**
     * @var ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog
     */
    private $timeLogs;


    /**
     * Add timeLogs
     *
     * @param ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLogs
     */
    public function addTimeLogs(\ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLogs)
    {
        $this->timeLogs[] = $timeLogs;
    }

    /**
     * Get timeLogs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTimeLogs()
    {
        return $this->timeLogs;
    }

    /**
     * Add emails
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Email $emails
     */
    public function addEmail(\ChatCreeSoftware\CoreBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;
    }

    /**
     * Add logs
     *
     * @param ChatCreeSoftware\CoreBundle\Entity\Log $logs
     */
    public function addLog(\ChatCreeSoftware\CoreBundle\Entity\Log $logs)
    {
        $this->logs[] = $logs;
    }

    /**
     * Add timeLogs
     *
     * @param ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLogs
     */
    public function addTimeLog(\ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLogs)
    {
        $this->timeLogs[] = $timeLogs;
    }
    /**
     * @var boolean $actor
     */
    private $actor;


    /**
     * Set actor
     *
     * @param boolean $actor
     */
    public function setActor($actor)
    {
        $this->actor = $actor;
    }

    /**
     * Get actor
     *
     * @return boolean 
     */
    public function getActor()
    {
        return $this->actor;
    }
    /**
     * @var string $company
     */
    private $company;

    /**
     * Set company
     *
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }
    /**
     * @var ChatCreeSoftware\ProjectManagementBundle\Entity\Journey
     */
    private $journeys;


    /**
     * Add journeys
     *
     * @param ChatCreeSoftware\ProjectManagementBundle\Entity\Journey $journeys
     */
    public function addJourney(\ChatCreeSoftware\ProjectManagementBundle\Entity\Journey $journeys)
    {
        $this->journeys[] = $journeys;
    }

    /**
     * Get journeys
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getJourneys()
    {
        return $this->journeys;
    }

    /**
     * Remove email
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Email $email
     */
    public function removeEmail(\ChatCreeSoftware\CoreBundle\Entity\Email $email)
    {
        $this->emails->removeElement($email);
    }

    /**
     * Remove log
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Log $log
     */
    public function removeLog(\ChatCreeSoftware\CoreBundle\Entity\Log $log)
    {
        $this->logs->removeElement($log);
    }

    /**
     * Remove timeLog
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLog
     */
    public function removeTimeLog(\ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLog)
    {
        $this->timeLogs->removeElement($timeLog);
    }

    /**
     * Remove journey
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Journey $journey
     */
    public function removeJourney(\ChatCreeSoftware\ProjectManagementBundle\Entity\Journey $journey)
    {
        $this->journeys->removeElement($journey);
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $resets;


    /**
     * Add reset
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Reset $reset
     *
     * @return User
     */
    public function addReset(\ChatCreeSoftware\CoreBundle\Entity\Reset $reset)
    {
        $this->resets[] = $reset;

        return $this;
    }

    /**
     * Remove reset
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Reset $reset
     */
    public function removeReset(\ChatCreeSoftware\CoreBundle\Entity\Reset $reset)
    {
        $this->resets->removeElement($reset);
    }

    /**
     * Get resets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResets()
    {
        return $this->resets;
    }
    
    /**
     * Get last login for user
     * 
     * @return \Datetime
     */
    public function getLastLogin(){
        $lastLogin = "";
        $currentLogin = "";
        foreach ($this->getLogs() as $log) {
            if ($log->getTimestamp() > $lastLogin && $log->getAction() == "Login") {
                $lastLogin = $currentLogin;
                $currentLogin = $log->getTimestamp();
            }
        }
        return [ "currentLogin" => $currentLogin, "lastLogin" => $lastLogin ];
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $devis;


    /**
     * Add devi
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Devis $devi
     *
     * @return User
     */
    public function addDevi(\ChatCreeSoftware\BordereauxBundle\Entity\Devis $devi)
    {
        $this->devis[] = $devi;

        return $this;
    }

    /**
     * Remove devi
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Devis $devi
     */
    public function removeDevi(\ChatCreeSoftware\BordereauxBundle\Entity\Devis $devi)
    {
        $this->devis->removeElement($devi);
    }

    /**
     * Get devis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevis()
    {
        return $this->devis;
    }
}
