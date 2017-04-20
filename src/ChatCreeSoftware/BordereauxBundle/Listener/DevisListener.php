<?php
namespace ChatCreeSoftware\BordereauxBundle\Listener;

use Symfony\Component\Security\Acl\Dbal\MutableAclProvider,
    Symfony\Component\Security\Acl\Domain\ObjectIdentity,
    Symfony\Component\Security\Acl\Domain\UserSecurityIdentity,
    Symfony\Component\Security\Acl\Permission\MaskBuilder,
    Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use Doctrine\ORM\Event\LifecycleEventArgs,
    Doctrine\ORM\Event\PreUpdateEventArgs;

use ChatCreeSoftware\BordereauxBundle\Entity\Devis,
    ChatCreeSoftware\BordereauxBundle\Entity\Ligne,
    ChatCreeSoftware\BordereauxBundle\Entity\LigneDevis;

class DevisListener 
{
    protected $aclProvider;
    protected $tokenStorage;

    public function __construct( MutableAclProvider $aclProvider, TokenStorage $tokenStorage ){
        $this->aclProvider = $aclProvider;
        $this->tokenStorage = $tokenStorage;
    }
    
    public function createLignesDevis( $em, $devis, Ligne $ligne ){
        if( $ligne->getFilles()->count() == 0 ){
            $ligneDevis = new LigneDevis( $devis, $ligne );
            $em->persist( $ligneDevis );
        } else {
            foreach( $ligne->getFilles() as $fille ){
                $this->createLignesDevis( $em, $devis, $fille );
            }
        }
        foreach( $ligne->getAlternatives() as $alternative ){
            $this->createLignesDevis( $em, $devis, $alternative );
        }
    }
    
    public function postPersist( Devis $devis, LifecycleEventArgs $event ) {
        $objectId = ObjectIdentity::fromDomainObject( $devis );
        $acl = $this->aclProvider->createAcl( $objectId );
        
        $owner = $this->tokenStorage->getToken()->getUser();
        $securityIdentity = UserSecurityIdentity::fromAccount($owner);
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER );
        
        $userIdentity = UserSecurityIdentity::fromAccount( $devis->getSoumissionnaire() );
        $acl->insertObjectAce($userIdentity, MaskBuilder::MASK_EDIT );

        $this->aclProvider->updateAcl($acl);
        
        // Generate DevisLigne entries
        $em = $event->getEntityManager();
        foreach( $devis->getBordereau()->getLignes() as $ligne ){
            $this->createLignesDevis($em, $devis, $ligne);
        }
        $em->flush();
    }
    
    public function postRemove( Devis $devis, LifecycleEventArgs $event ) {
        $em = $event->getEntityManager();
        foreach( $devis->getLignes() as $ligne ){
            $em->remove($ligne);
        }
        $em->flush();
    }
}