<?php
namespace ChatCreeSoftware\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ChatCreeSoftware\CoreBundle\Listener\InterfaceEvent;

class CommonController extends Controller {
    
    /**
     * 
     * @Route( "/core/home", name="_core_home"  )
     * @Template
     * 
     */
    public function homeAction( ){
        return( array() );
    }
    
    public function mainMenuAction( $menu_selected = 0 ) {
        $dispatcher = $this->get('event_dispatcher');

        $event = new InterfaceEvent();
        
        $dispatcher->dispatch(InterfaceEvent::onMenuDisplay, $event);
                
        return $this->render( "CoreBundle:Common:mainMenu.html.twig", array(
            "menu" => $event->getMenu(),
            "menu_selected" => $menu_selected 
            ) );
    }
}