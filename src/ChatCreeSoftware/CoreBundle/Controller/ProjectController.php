<?php
namespace ChatCreeSoftware\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response;      

class ProjectController extends Controller {
    
    /**
     * 
     * @Route( "/core/ajax/projet/liste", name="_ajax_project_list"  )
     * 
     */
    public function ajaxListeProjectAction( ){
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