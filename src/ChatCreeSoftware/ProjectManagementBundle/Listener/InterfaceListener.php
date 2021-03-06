<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Listener;

use ChatCreeSoftware\CoreBundle\Listener\InterfaceListenerInterface;
use ChatCreeSoftware\CoreBundle\Listener\InterfaceEvent;

class InterfaceListener extends InterfaceListenerInterface
{
   
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
