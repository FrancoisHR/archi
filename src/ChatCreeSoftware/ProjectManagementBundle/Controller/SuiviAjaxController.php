<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Flags,
    ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog,
    Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Security\Core\User\UserInterface;

class SuiviAjaxController extends Controller
{
    
    /**
     * @Route( "/gestion/project/ajax/monthly/summary/{date}", name="_gestion_project_ajax_monthly" )
     */
    public function listMonthlyAction( $date ) {
        $em = $this->get('doctrine')->getManager();    
        
        $query = $em->createQuery(
                "select u, sum(l.hours), sum(l.minutes) from ProjectManagementBundle:TimeLog l, CoreBundle:User u where l.user=u and l.date like '$date-%' group by u");

        $results = $query->getResult();
        
        $ajaxResult = array(
            'data' => array()
        );
        
        foreach( $results as $result ){
            $user = $result[0];
            $username = $user->getLastname() . ' ' . $user->getFirstname();
            $hours = $result[1];
            if(is_null($hours)){
                $hours = 0;
            }
            $minutes = $result[2];
            if( is_null($minutes)){
                $minutes = 0;
            }
            if( $minutes >= 60){
                $eHours = floor( $minutes / 60 );
                
                $hours += $eHours;
                $minutes -= $eHours*60; 
                
            }
            $time = sprintf( "%02d:%02d", $hours, $minutes);
            $row = array( $user->getId(), $username, $time );
            
            $ajaxResult['data'][] = $row;
        }
        
        $return = json_encode( $ajaxResult );
        
        return new Response( $return, 200);
    }
    
    /**
     * @Route("/gestion/project/ajax/autocomplete/project", name="_gestion_project_ajax_autocomplete_project" )
     */
    public function projectAutocompleteAction( Request $request  ){
        $name = $request->get('query');
        
        $ajaxResult= array( 'query' => $name );
        
        $em = $this->get('doctrine')->getManager();    
        $query = $em->createQuery( 'select p from CoreBundle:Project p where p.projectName like :name order by p.projectName')
                    ->setParameter('name', '%'. $name . '%' );
        
        $projects = $query->getResult();
        $suggestionArray = array();
        foreach ($projects as $project ) {
            $suggestionArray[] = $project->getProjectName();
        }
        
        $ajaxResult[ 'suggestions' ] = $suggestionArray;
        $return = json_encode( $ajaxResult );
        return new Response( $return, 200);
        
    }
    
    /**
     * @Route( "/gestion/project/ajax/monthly/graph", name="_gestion_project_ajax_monthy_graph" )
     */
    public function projectMonthlyGraphAction( Request $request ){
        $userId = $request->get('id');
        $month = $request->get('month');
        
        $start = new \DateTime( $month . '-01' );
        $end = date( "t", strtotime($month . '-01') );
        
        $em = $this->get('doctrine')->getManager();    
        
        $ajaxResult = array();
        $data = array();
        for( $day=1; $day <= $end; $day++ ) {
            $date = "$month-$day";
            $query = $em->createQuery(
                "select sum(l.hours), sum(l.minutes) from ProjectManagementBundle:TimeLog l, CoreBundle:User u where l.user=u and u.id=$userId and l.date = '$date'");

            $results = $query->getResult();
            $hours= $results[0][1];
            if(is_null($hours)){
                $hours = 0;
            }
            $minutes = $results[0][2];
            if( is_null($minutes)){
                $minutes = 0;
            }            
            
            $time = $hours + $minutes / 60;
            
            $data[] = array( $month . "-$day", $time );
        }
        
        $ajaxResult[] = $data;
        
        $return = json_encode( $ajaxResult );
        
        return new Response( $return, 200);
        
    }
    
    /**
     * @Route( "/gestion/ajax_list_user_logs/{date}", name="_ajax_list_user_logs", defaults={ "date"="now" } )
     */
    public function listProjectAction( UserInterface $user, $date ){        
        $em = $this->get('doctrine')->getManager();    
        $repo = $em->getRepository('ProjectManagementBundle:TimeLog');
       
        // Process the date
        if( $date == "" || $date=="now" ){
            $now = new \DateTime();
            $date = $now->format( 'Y-m-d' );
        }

        $query = $repo->createQueryBuilder('t')
                ->where( 't.date = :date and t.user = :user')
                ->setParameter( 'date', $date )
                ->setParameter( 'user', $user )
                ->orderBy('t.date','ASC')->getQuery();
        $timelogs = $query->getResult();
                
        $ajaxResult = array();
        $data = array();
        foreach ($timelogs as $log) {
            $logObject = array(
                "id" => $log->getId(),
                "projectId" => $log->getProject()->getId(),
                $log->getProject()->getProjectName(),
                sprintf( "%02d:%02d",$log->getHours(),$log->getMinutes()),
                $log->getDescription());

            $data[] = $logObject;
        }
        
        $ajaxResult["data"] = $data;
                
        $return = json_encode( $ajaxResult );
        
        return new Response( $return, 200);
    }
    
    /**
     * @Route( "/gestion/project/ajax/suivi/new_user_log", name="_ajax_new_user_log"  )
     */
    public function newUserLogAction( Request $request, UserInterface $user ) {        
        $id = $request->get('id');
        $pname = $request->get('pname');
        $action = $request->get('action');
        $date = $request->get('date');
        $hours = $request->get('hours');
        $minutes = $request->get('minutes');
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
        
        if( $action=="U" && $id ) {
            $tRepo = $em->getRepository('ProjectManagementBundle:TimeLog');
            $log=$tRepo->find( $id );
            
            if( isset($log) ) {
                if (isset($project) ){
                    $log->setProject( $project );
                }
            } else {
                $return = array("response"=>500, "message" => "No log" );
                $return = json_encode( $return );
                return new Response( $return, 200);                   
            }
        } else if( $action=="C" ) {
            if( isset($project) ) {
                $log = new TimeLog();
                $log->setProject( $project );
                $em->persist( $log );
            } else {
                $return = array("response"=>500, "message" => "No Project" );
                $return = json_encode( $return );
                return new Response( $return, 200);   
            }           
        }
        
        $log->setHours($hours);
        $log->setMinutes($minutes);
        $log->setDescription($description);
        $log->setUser($user);
        $log->setDate( $date );        
        
        $em->persist( $log );
        $em->flush();
        
                  
        $return = array("response"=>200 );
        
        $return = json_encode( $return );
        return new Response( $return, 200);         
    }

    /**
     * @Route( "/gestion/project/ajax/suivi/user/delete", name="_project_user_log_ajax_delete")
     */
    public function deleteUserLogAction( Request $request ){
        $logId = $request->get('id');
        
        // Get the log
        $em = $this->get('doctrine')->getManager();    
        $repo = $em->getRepository('ProjectManagementBundle:TimeLog');
        $log=$repo->find( $logId );        
        
        $em->remove( $log );
        $em->flush();
        
        $return = array("response"=>200);
        $return = json_encode( $return );
        return new Response( $return, 200);
    }    
    
    /**
     * @Route( "/gestion/project/ajax/suivi/user/update", name="_project_user_log_ajax_update" )
     */
    public function newProjectLogAction( Request $request ){
        $id = $request->get('id');
        $pid = $request->get('pid');
        $action = $request->get('action');
        $date = $request->get('date');
        $userId = $request->get('user');
        $hours = $request->get('hours');
        $minutes = $request->get('minutes');
        $description = $request->get('description');

        // Process the date
        if( $date == "" || $date=="now" ){
            $date = new \DateTime();
        } else {
            $date = \DateTime::createFromFormat("d/m/Y", $date);
        }     
        
        $em = $this->get('doctrine')->getManager();    
        if( $action=="U" && $id ) {
            $tRepo = $em->getRepository('ProjectManagementBundle:TimeLog');
            $log=$tRepo->find( $id );
        } else if( $action=="C" ) {
            if( $pid ) {
                $pRepo = $em->getRepository('CoreBundle:Project');
                $project = $pRepo->find( $pid );
                
                $log = new TimeLog();
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
        
        $log->setHours($hours);
        $log->setMinutes($minutes);
        $log->setDescription($description);
        $log->setUser($user);
        $log->setDate( $date );        

        $em->persist( $log );
        $em->flush();
        
                  
        $return = array("response"=>200 );
        
        $return = json_encode( $return );
        return new Response( $return, 200);     
    }
}
