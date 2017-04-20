<?php

namespace ChatCreeSoftware\CoreBundle\Listener;

use Symfony\Component\Security\Acl\Dbal\MutableAclProvider,
    Symfony\Component\Security\Acl\Domain\ObjectIdentity,
    Symfony\Component\Security\Acl\Domain\UserSecurityIdentity,
    Symfony\Component\Security\Acl\Permission\MaskBuilder,
    Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use ChatCreeSoftware\CoreBundle\Entity\Project;

class ProjectListener 
{
    protected $aclProvider;

    public function __construct( MutableAclProvider $aclProvider, TokenStorage $tokenStorage ){
        $this->aclProvider = $aclProvider;
        $this->tokenStorage = $tokenStorage;
    }
    
    public function postPersist( Project $project ) {
        $objectId = ObjectIdentity::fromDomainObject( $project );
        $acl = $this->aclProvider->createAcl( $objectId );
        
        $user = $this->tokenStorage->getToken()->getUser();
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER );
        $this->aclProvider->updateAcl($acl);

    }    
    public function postRemove( Project $project ) {
        $objectId = ObjectIdentity::fromDomainObject( $project );
        $this->aclProvider->deleteAcl( $objectId );
    }
}