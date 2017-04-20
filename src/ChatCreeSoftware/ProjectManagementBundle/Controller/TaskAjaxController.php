<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Project,
    ChatCreeSoftware\ProjectManagementBundle\Entity\Task,
    Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class TaskAjaxController  extends Controller{

    /**
     * @Route( "/gestion/ajax_list_project_tasks/{id}", name="_ajax_list_project_tasks" )
     */
    public function listProjectTasksAction( Project $project ){
        
        $ajaxResult = array();
        $data = array();
        foreach ($project->getTasks() as $task) {
            $targetDate ="";
            $finalizeDate ="";
            
            if( $task->getTarget() )
                $targetDate=$task->getTarget()->format('d/m/Y');
            if( $task->getFinalize() )
                $finalizeDate=$task->getFinalize()->format('d/m/Y');
            
            $taskObject = array(
                "id" => $task->getId(),
                $task->getName(),
                $targetDate,
                $finalizeDate);

            $data[] = $taskObject;
        }
        
        $ajaxResult["data"] = $data;
        $return = json_encode( $ajaxResult );
        return new Response( $return, 200);
    }    
    
    
    /**
     * @Route( "/gestion/project/ajax/task/delete", name="_project_task_ajax_delete" )
     */
    public function deleteProjectTask( Request $request ) {
        $iId = $request->get('id');
        
        if( $iId ) {
            $em = $this->get('doctrine')->getManager();
            $repo = $em->getRepository('ProjectManagementBundle:Task');
            
            $task = $repo->find( $iId );
            
            $em->remove( $task );
            $em->flush();
            
            $returnArray = array( "response" => 200 );
        } else {
            $returnArray = array( "response" => 500 );            
        }
        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);        
    }
    
    /**
     * @Route( "/gestion/project/ajax/task/update", name="_project_task_ajax_update"  )
     */
    public function newProjectTask( Request $request  ){
        $id = $request->get('id');
        $pid = $request->get('pid');
        $action = $request->get('action');       
        $taskName = $request->get('taskName');
        $targetDate = $request->get('targetDate');
        $finalizeDate = $request->get('finalizeDate');
                
        
        $em = $this->get('doctrine')->getManager();
        
        if( $action=="U" && $id ) {
            $tRepo = $em->getRepository('ProjectManagementBundle:Task');
            
            $task = $tRepo->find( $id );
        } else {
            if( $pid ) {
                $pRepo = $em->getRepository('CoreBundle:Project');
                
                $project = $pRepo->find( $pid );
                
                $task = new Task();
                $task->setProject( $project );
                $em->persist( $task );
            }
        }
        
        $task->setName($taskName);

        if( $targetDate ) {
            $targetDate = \DateTime::createFromFormat( 'd/m/Y', $targetDate );
            $task->setTarget($targetDate);
        } else {
            $task->setTarget(NULL);
        }
        
        if( $finalizeDate ){
            $finalizeDate = \DateTime::createFromFormat( 'd/m/Y', $finalizeDate );
            $task->setFinalize($finalizeDate);
        } else {
            $task->setFinalize(NULL);
        }
        
        $em->flush();
        
        $return = array("response"=>200);
        $return = json_encode( $return );
        return new Response( $return, 200);
    }
}

?>
