<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Listener;

use Symfony\Bundle\FrameworkBundle\Routing\Router,
    Symfony\Component\EventDispatcher\EventSubscriberInterface,
    Symfony\Component\Security\Acl\Dbal\MutableAclProvider,
    Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

use Doctrine\ORM\EntityManager;

use ChatCreeSoftware\CoreBundle\Listener\InterfaceEvent;

class InterfaceListener implements EventSubscriberInterface
{
    protected $entityManager;
    protected $aclProvider;
    protected $authorization_checker;
    protected $router;

    public function __construct( EntityManager $entityManager, MutableAclProvider $aclProvider, AuthorizationChecker $authorization_checker, Router $router ){
        $this->entityManager = $entityManager;
        $this->aclProvider = $aclProvider;
        $this->authorization_checker = $authorization_checker;
        $this->router = $router;
    }
    
    static public function getSubscribedEvents() {
        return array(
            InterfaceEvent::onMenuDisplay => 'menuDisplay'
        );
    }
    
    public function menuDisplay( InterfaceEvent $event ) {
        $menu = $event->getMenu();
        if ( $this->authorization_checker->isGranted('ROLE_EMPLOYEE')) {
            $menu[] = array( "selectionId" => 5, "name" => "Interface Gestion", "url" => $this->router->generate( "_gestion_main" ) );
        }
        if ( $this->authorization_checker->isGranted('ROLE_ADMIN')) {
            $menu[] = array( "selectionId" => 7, "name" => "Utilisateurs", "url" => $this->router->generate( "_admin_list_users" ) );
            $menu[] = array( "selectionId" => 8, "name" => "Créer un utilisateur", "url" => $this->router->generate( "_admin_user_create" ) );
            $menu[] = array( "selectionId" => 9, "name" => "Dernières connexions", "url" => $this->router->generate( "_admin_last_user_login" ) );
        }
        $event->setMenu($menu);
    }
}
