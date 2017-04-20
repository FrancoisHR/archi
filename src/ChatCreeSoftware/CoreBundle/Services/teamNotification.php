<?php

namespace ChatCreeSoftware\CoreBundle\Services;

use ChatCreeSoftware\CoreBundle\Entity\Project,
    ChatCreeSoftware\CoreBundle\Entity\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;

class TeamNotification {
    
    protected $entityManager;
    protected $aclProvider;
    protected $mailer;
    protected $twig;
    
    public function __construct( EntityManager $entityManager, \Swift_Mailer $mailer, MutableAclProvider $aclProvider, \Twig_Environment $twig ){
        $this->entityManager = $entityManager;
        $this->aclProvider = $aclProvider;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function mailFileNotifications(User $user, Project $project, $link, $message ) {
        
    }
}