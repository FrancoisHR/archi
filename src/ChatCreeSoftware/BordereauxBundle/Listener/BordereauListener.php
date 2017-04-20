<?php

namespace ChatCreeSoftware\BordereauxBundle\Listener;

use Symfony\Component\Security\Acl\Dbal\MutableAclProvider,
    Symfony\Component\Security\Acl\Domain\ObjectIdentity,
    Symfony\Component\Security\Acl\Domain\UserSecurityIdentity,
    Symfony\Component\Security\Acl\Permission\MaskBuilder,
    Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use ChatCreeSoftware\BordereauxBundle\Entity\Bordereau;

class BordereauListener 
{
    protected $aclProvider;
    protected $tokenStorage;

    public function __construct( MutableAclProvider $aclProvider, TokenStorage $tokenStorage ){
        $this->aclProvider = $aclProvider;
        $this->tokenStorage = $tokenStorage;
    }
    
    public function postPersist( Bordereau $bordereau ) {
        $objectId = ObjectIdentity::fromDomainObject( $bordereau );
        $acl = $this->aclProvider->createAcl( $objectId );
        
        $user = $this->tokenStorage->getToken()->getUser();
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER );
        $this->aclProvider->updateAcl($acl);

    }
}