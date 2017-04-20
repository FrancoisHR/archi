<?php

namespace ChatCreeSoftware\FileserverBundle\Listener;

use ChatCreeSoftware\CoreBundle\Listener\InterfaceListenerInterface;
use ChatCreeSoftware\CoreBundle\Listener\InterfaceEvent;

class InterfaceListener extends InterfaceListenerInterface
{
   
    public function menuDisplay( InterfaceEvent $event ) {
        $menu = $event->getMenu();
        $menu[] = array( "selectionId" => 1, "name" => "Mes projets", "url" => $this->router->generate( "_project_list" ) );
        $event->setMenu($menu);        
    }
}
