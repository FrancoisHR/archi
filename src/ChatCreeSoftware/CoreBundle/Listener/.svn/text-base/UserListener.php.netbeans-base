<?php

namespace ChatCreeSoftware\CoreBundle\Listener;

use Symfony\Component\Security\Acl\Dbal\MutableAclProvider,
    Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Doctrine\ORM\Event\LifecycleEventArgs,
    Doctrine\ORM\Event\PreUpdateEventArgs;

use ChatCreeSoftware\CoreBundle\Entity\User;

class UserListener 
{
    protected $aclProvider;

    public function __construct( MutableAclProvider $aclProvider ){
        $this->aclProvider = $aclProvider;
    }
    
    public function preUpdate(  User $user, PreUpdateEventArgs $event ){
        if( $event->hasChangedField( "login" )){
            $securityId = UserSecurityIdentity::fromAccount($user);
            $this->aclProvider->updateUserSecurityIdentity($securityId, $event->getOldValue( "login" ) );
        }
    }

    public function postRemove( User $user, LifecycleEventArgs $event ) {     
        $securityId = UserSecurityIdentity::fromAccount($user);
        $this->aclProvider->deleteSecurityIdentity( $securityId );
    }
}