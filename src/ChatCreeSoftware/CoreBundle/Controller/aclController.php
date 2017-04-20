<?php

namespace ChatCreeSoftware\CoreBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class aclController extends Controller {
    
    /**
     * @Route('/security/acl', '_security_acl')
     * @Template
     * @param Request $request
     * @param UserInterface $user
     */
    public function listAclAction( Request $request, UserInterface $user ){
        return( [] );
    }
}