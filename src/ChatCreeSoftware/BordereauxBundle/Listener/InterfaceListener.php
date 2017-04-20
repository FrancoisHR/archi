<?php

namespace ChatCreeSoftware\BordereauxBundle\Listener;

use ChatCreeSoftware\CoreBundle\Listener\InterfaceListenerInterface;
use ChatCreeSoftware\CoreBundle\Listener\InterfaceEvent;

class InterfaceListener extends InterfaceListenerInterface
{
    public function menuDisplay( InterfaceEvent $event ) {
        if ( $this->authorization_checker->isGranted('ROLE_PROVIDER')) {
            $menu = $event->getMenu();
        
            $menu[] = array( "selectionId" => 11, "name" => "Mes Bordereaux", "url" => $this->router->generate( "_bordereaux_index" ) );
        
            $event->setMenu($menu);
        }
    }
}
