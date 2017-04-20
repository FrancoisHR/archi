<?php
namespace ChatCreeSoftware\CoreBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;      

class ProjectController extends Controller {
    
    /**
     * 
     * @Route( "/core/ajax/projet/liste", name="_ajax_project_list"  )
     * 
     */
    public function ajaxListeProject( ){
        $em = $this->get('doctrine')->getManager();
        $projectRepo = $em->getRepository('CoreBundle:Project');
        $projects  = $projectRepo->findAll();
        
        $ajaxResult = array();
        $data = array();
                
        foreach ( $projects as $project ) {
            $projectObject = array(
                "id" => $project->getId(),
                "name" => $project->getProjectName());

                $data[] = $projectObject;
        }
        
        $ajaxResult["data"] = $data;
        $return = json_encode($ajaxResult);
        return new Response($return, 200);
    }    
    
}