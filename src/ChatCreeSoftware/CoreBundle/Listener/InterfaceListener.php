<?php

namespace ChatCreeSoftware\CoreBundle\Listener;

use ChatCreeSoftware\CoreBundle\Listener\InterfaceListenerInterface;
use ChatCreeSoftware\CoreBundle\Listener\InterfaceEvent;

class InterfaceListener extends InterfaceListenerInterface
{
    
    public function menuDisplay( InterfaceEvent $event ) {
        $menu = $event->getMenu();
    //    $menu[] = array( "selectionId" => 4, "name" => "Mon compte", "url" => "#" );
    //    $menu[] = array( "selectionId" => 3, "name" => "Mes échanges", "url" => "#" );
        $event->setMenu($menu);
    }
}
