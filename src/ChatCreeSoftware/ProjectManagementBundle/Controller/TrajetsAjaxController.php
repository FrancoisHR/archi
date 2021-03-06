<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Flags,
    ChatCreeSoftware\ProjectManagementBundle\Entity\Journey,
    Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Security\Core\User\UserInterface;

class TrajetsAjaxController extends Controller {
    /**
     * @Route( "/gestion/ajax_list_user_trajets/{date}", name="_ajax_list_user_trajets", defaults={ "date"="now" } )
     */
    public function listUserTrajetsAction( UserInterface $user, $date ){       
        $em = $this->get('doctrine')->getManager();    
        $repo = $em->getRepository('ProjectManagementBundle:Journey');
       
        // Process the date
        if( $date == "" || $date=="now" ){
            $now = new \DateTime();
            $date = $now->format( 'Y-m-d' );

        }

        $query = $repo->createQueryBuilder('j')
                ->where( 'j.date = :date and j.user = :user')
                ->setParameter( 'date', $date )
                ->setParameter( 'user', $user )
                ->orderBy('j.date','ASC')->getQuery();
        $journeys = $query->getResult();
                
        $ajaxResult = array();
        $data = array();
        foreach ($journeys as $journey) {
            $journeyObject = array(
                "id" => $journey->getId(),
                "projectId" => $journey->getProject()->getId(),
                $journey->getProject()->getProjectName(),
                $journey->getStart(),
                $journey->getEnd(),
                $journey->getDistance(),
                $journey->getDescription()
            );

            $data[] = $journeyObject;
        }
        
        $ajaxResult["data"] = $data;
                
        $return = json_encode( $ajaxResult );
        
        return new Response( $return, 200);
    }

    
    
    /**
     * @Route( "/gestion/ajax_list_project_trajets/{projectId}", name="_ajax_list_project_trajets", defaults={ "projectId"=0 } )
     */
    public function listProjectTrajetsAction( $projectId ){      
        $em = $this->get('doctrine')->getManager();    
        $repo = $em->getRepository('CoreBundle:Project');
      
        $project = $repo->find( $projectId );
                
        $ajaxResult = array();
        $data = array();
        foreach ($project->getJourneys() as $journey) {
            $journeyObject = array(
                "id" => $journey->getId(),
                $journey->getDate()->format("d/m/Y"),
                $journey->getUser()->getLastname() . ' ' . $journey->getUser()->getFirstname(),
                $journey->getStart(),
                $journey->getEnd(),
                $journey->getDistance(),
                $journey->getDescription(),
/*                "Date" => $journey->getDate()->format("d/m/Y"),
                "User" => $journey->getUser()->getLastname() . ' ' . $journey->getUser()->getFirstname(),
                "Start" => $journey->getStart(),
                "End" => $journey->getEnd(),
                "Distance" => $journey->getDistance(),
                "Description" => $journey->getDescription(), */
            );

            $data[] = $journeyObject;
        }
        
        $ajaxResult["data"] = $data;
                
        $return = json_encode( $ajaxResult );
        
        return new Response( $return, 200);
    }

    
    /**
     * @Route( "/gestion/project/ajax/delete_user_trajet", name="_ajax_delete_user_trajets")
     */
    public function deleteUserTrajetAction( Request $request ){
        $journeyId = $request->get('id');
        
        // Get the log
        $em = $this->get('doctrine')->getManager();    
        $repo = $em->getRepository('ProjectManagementBundle:Journey');
        $journey=$repo->find( $journeyId );        
        
        $em->remove( $journey );
        $em->flush();
        
        $returnArray = array("response"=>200);
        $return = json_encode( $returnArray );
        return new Response( $return, 200);
    }    

    /**
     * @Route( "/gestion/project/ajax/suivi/delete", name="_ajax_delete_projet_trajets")
     */
    public function deleteUserLogAction( Request $request ){
        $journeyId = $request->get('id');
        
        // Get the log
        $em = $this->get('doctrine')->getManager();    
        $jRepo = $em->getRepository('ProjectManagementBundle:Journey');
        $journey=$jRepo->find( $journeyId );        
        
        $em->remove( $journey );
        $em->flush();
        
        $return = array("response"=>200);
        $return = json_encode( $return );
        return new Response( $return, 200);
    }    
    
    
    /**
     * @Route( "/gestion/project/ajax/trajets/update_user_trajet", name="_ajax_update_user_trajet" )
     */
    public function updateUserTrajetAction( Request $request, UserInterface $user ) {        
        $id = $request->get('id');
        $pname = $request->get('pname');
        $action = $request->get('action');
        $date = $request->get('date');
        $start = $request->get('start');
        $end = $request->get('end');
        $distance = $request->get('distance');
        $description = $request->get('description');

        // Process the date
        if( $date == "" || $date=="now" ){
            $date = new \DateTime();
        } else {
            $date = \DateTime::createFromFormat("d/m/Y", $date);
        }       
        
        $em = $this->get('doctrine')->getManager();       
        if( $pname ) {
            $pRepo = $em->getRepository('CoreBundle:Project');
            $project = $pRepo->findOneByProjectName( $pname );
        }
        
        $log = null;
        if( $action=="U" && $id ) {
            $jRepo = $em->getRepository('ProjectManagementBundle:Journey');
            $log=$jRepo->find( $id );
            
            if( isset($log) ) {
                if (isset($project) ){
                    $log->setProject( $project );
                }
            } else {
                $returnArray = array("response"=>500, "message" => "No log" );
                $return = json_encode( $returnArray );
                return new Response( $return, 200);                   
            }
        } else if( $action=="C" ) {
            if( isset($project) ) {
                $log = new Journey();
                $log->setProject( $project );
                $em->persist( $log );
            } else {
                $returnArray = array("response"=>500, "message" => "No Project" );
                $return = json_encode( $returnArray );
                return new Response( $return, 200);   
            }           
        }
        
        $log->setStart($start);
        $log->setEnd($end);
        $log->setDistance($distance);
        $log->setDescription($description);
        $log->setUser($user);
        $log->setDate( $date );        

        $em->persist( $log );
        $em->flush();
        
        $returnArray = array("response"=>200 );
        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);         
    }
    
    /**
     * @Route( "/gestion/project/ajax/trajet/project/update", name="_ajax_update_project_trajet" )
     */
    public function updateProjectJourneyAction( Request $request ){
        $id = $request->get('id');
        $pid = $request->get('pid');
        $action = $request->get('action');
        $date = $request->get('date');
        $userId = $request->get('user');
        $start = $request->get('start');
        $end = $request->get('end');
        $distance = $request->get('distance');
        $description = $request->get('description');

        // Process the date
        if( $date == "" || $date=="now" ){
            $date = new \DateTime();
        } else {
            $date = \DateTime::createFromFormat("d/m/Y", $date);
        }       
        
        $log=null;
        $em = $this->get('doctrine')->getManager();    
        if( $action=="U" && $id ) {
            $tRepo = $em->getRepository('ProjectManagementBundle:Journey');
            $log=$tRepo->find( $id );
        } else if( $action=="C" ) {
            if( $pid ) {
                $pRepo = $em->getRepository('CoreBundle:Project');
                $project = $pRepo->find( $pid );
                
                $log = new Journey();
                $log->setProject( $project );
                $em->persist( $log );
            }
        } else {
            $return = array("response"=>500, "message" => "Invalid Action" );
        
            $return = json_encode( $return );
            return new Response( $return, 200);            
        }
        
        // Get the user
        $repo = $em->getRepository('CoreBundle:User');
        $user=$repo->find( $userId );
        
        $log->setStart($start);
        $log->setEnd($end);
        $log->setDistance($distance);
        $log->setDescription($description);
        $log->setUser($user);
        $log->setDate( $date );        

        $em->persist( $log );
        $em->flush();
        
        $id=$log->getId();
                  
        $return = array("response"=>200, "id"=>$id );
        
        $return = json_encode( $return );
        return new Response( $return, 200);      
   }
   
    
}
