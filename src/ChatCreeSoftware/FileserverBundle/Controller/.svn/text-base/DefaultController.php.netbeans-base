<?php

namespace ChatCreeSoftware\FileserverBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/projets/liste", name="_project_list")
     * @Template
     */
    public function indexAction( UserInterface $user )
    {
        // $em = $this->get('doctrine')->getManager();    
        // $repo = $em->getRepository('CoreBundle:Project');
        // $query = $repo->createQueryBuilder('p')
        //         ->orderBy('p.projectName','ASC')->getQuery();
        // $projects = $query->getResult();
                
        $connection = $this->get('database_connection');
        $projects = $connection->fetchAll('select p.id, p.projectName "projectName", e.mask "mask" from acl_security_identities s ' . 
                'join acl_entries e on e.security_identity_id = s.id ' .
                'join acl_classes c on e.class_id = c.id ' .
                'join acl_object_identities o on e.object_identity_id = o.id ' .
                'join CoreProject p on o.object_identifier = p.id ' .
                'where s.identifier = "ChatCreeSoftware\\\\CoreBundle\\\\Entity\\\\User-' . $user->getLogin() . '" ' .
                'and c.class_type = "ChatCreeSoftware\\\\CoreBundle\\\\Entity\\\\Project" ' .
                'and e.mask > 0 order by p.projectName' );
        
        return array( 'projects' => $projects );
    }
}
