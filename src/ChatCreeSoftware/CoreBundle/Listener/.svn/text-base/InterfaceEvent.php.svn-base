<?php

namespace ChatCreeSoftware\CoreBundle\Listener;

use Symfony\Component\EventDispatcher\Event;

final class InterfaceEvent extends Event
{
    const onMenuDisplay = "core.menu.display";

    protected $menu;
    
    public function __construct(){
        $this->menu = [];
    }
    
    public function getMenu(){
        return $this->menu;
    }
    
    public function setMenu( $menu ){
        $this->menu = $menu;
    }
}
