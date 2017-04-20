<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

/**
 */
class NavigationController extends Controller {

    public function navigationAction( $selected=0 ){
        $em = $this->get('doctrine')->getManager();
                
        $repo = $em->getRepository('CoreBundle:Project');
        $query = $repo->createQueryBuilder('p')
                ->orderBy('p.projectName','DESC')->getQuery();
        $projects = $query->getResult();
        
        return $this->render('ProjectManagementBundle:Navigation:navigation.html.twig', array( 
            "projects" => $projects,
            "selected" => $selected ));
    }
    
    public function projectNavigationAction($id, $selected = 0, $name=""){
        
        return $this->render('ProjectManagementBundle:Navigation:projectNavigation.html.twig', array(
            "selected" => $selected,
            "projectId" => $id,
            "name" => $name
        ));
    }
}
?>
