<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Flags,
    ChatCreeSoftware\CoreBundle\Entity\LogBook,
    ChatCreeSoftware\CoreBundle\Entity\Project;
use ChatCreeSoftware\CoreBundle\EntityProject;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class LogbookAjaxController extends Controller {

    /**
     * @Route( "/gestion/ajax_list_project_logbook/{id}", name="_ajax_list_project_logbook", defaults={ "id"=0 } )
     */
    public function listProjectLogBookAction( Project $project) {
        $ajaxResult = array();
        $data = array();
                
        if ($project->getLogBook()) {
            foreach ($project->getLogBook() as $logbook) {
                $logBookObject = array(
                    "date" => $logbook->getDate()->format("d/m/Y"),
                    "type" => $logbook->getLogType()->getFlagLabel(),
                    "user" => $logbook->getUser()->getLastname() . ' ' . $logbook->getUser()->getFirstname(),
                    "text" => $logbook->getTexte(),
                    "locked" => $logbook->getLocked(),
                    "ip" => $logbook->getIp(),
                    "id" => $logbook->getId());

                $data[] = $logBookObject;
            }
        }
        $ajaxResult["data"] = $data;
        $return = json_encode($ajaxResult);
        return new Response($return, 200);
    }

    /**
     * @Route( "/gestion/project/ajax/logbook/delete", name="_project_logbook_ajax_delete" )
     */
    public function deleteProjectLogbookAction( Request $request ) {
        $iId = $request->get('id');

        if ($iId) {
            $em = $this->get('doctrine')->getManager();
            $repo = $em->getRepository('CoreBundle:LogBook');

            $log = $repo->find($iId);

            $em->remove($log);
            $em->flush();

            $returnArray = array("response" => 200);
        } else {
            $returnArray = array("response" => 500);
        }

        $return = json_encode($returnArray);
        return new Response($return, 200);
    }

    /**
     * @Route( "/gestion/project/ajax/logbook/update", name="_project_logbook_ajax_update"  )
     */
    public function newProjectLogBookAction( Request $request ) {
        $id = $request->get('id');
        $pid = $request->get('pid');
        $logtypeId = $request->get('logtype');
        $date = $request->get('date');
        $userId = $request->get('user');
        $text = $request->get('text');
        $action = $request->get('action');

        $em = $this->get('doctrine')->getManager();

        // Get the user
        $userRepo = $em->getRepository('CoreBundle:User');
        $user = $userRepo->find($userId);
        
        // Get the LogType Flag
        $FlagsRepo = $em->getRepository('CoreBundle:Flags');
        $logtype = $FlagsRepo->find($logtypeId);
        
        if ($action == "U" && $id) {
            $tRepo = $em->getRepository('CoreBundle:LogBook');
            $logBook = $tRepo->find($id);

            $logBook->setUser($user);
            $logBook->setLogType($logtype);
            if ($date) {
                $date = \DateTime::createFromFormat('d/m/Y', $date);
                $logBook->setDate($date);
            } else {
                $logBook->setDate(NULL);
            }
        } else {
            if ($pid) {
                $pRepo = $em->getRepository('CoreBundle:Project');
                $project = $pRepo->find($pid);

                $logBook = new LogBook( $project, $logtype, $user, false );
                if ($date) {
                    $date = \DateTime::createFromFormat('d/m/Y', $date);
                    $logBook->setDate($date);
                }                
                $em->persist($logBook);
            }
        }

        $logBook->setTexte($text);

        $em->flush();

        $returnArray = array("response" => 200);
        $return = json_encode($returnArray);
        return new Response($return, 200);
    }

}
