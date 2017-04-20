<?php

namespace ChatCreeSoftware\CoreBundle\Listener;

use Symfony\Bundle\FrameworkBundle\Routing\Router,
    Symfony\Component\EventDispatcher\EventSubscriberInterface,
    Symfony\Component\Security\Acl\Dbal\MutableAclProvider,
    Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

use Doctrine\ORM\EntityManager;

use ChatCreeSoftware\CoreBundle\Listener\InterfaceEvent;

class InterfaceListenerInterface implements EventSubscriberInterface
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

    }
}
