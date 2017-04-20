<?php
namespace ChatCreeSoftware\BordereauxBundle\Controller;

use ChatCreeSoftware\BordereauxBundle\Entity\Devis,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\Security\Core\User\UserInterface;      

class PublicController extends Controller {

    /**
     * @Route("/bordereaux/index", name="_bordereaux_index")
     * @Template
     */
    public function indexAction( UserInterface $user )
    {
        return ["devis" => $user->getDevis()];
    }
    
    /**
     * @Route("/bordereaux/devis/{id}", name="_bordereaux_devis")
     * @Template
     */
    public function devisAction( Devis $devis){
        return ["devis" => $devis];
    }
}