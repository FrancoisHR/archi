<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Flags,
    ChatCreeSoftware\CoreBundle\Entity\Project,
    ChatCreeSoftware\ProjectManagementBundle\Entity\Address;
use ChatCreeSoftware\ProjectManagementBundle\Entity\Invoicing;
use ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/gestion/main", name="_gestion_main")
     * @Template
     */
    public function indexAction()
    {
        $em = $this->get('doctrine')->getManager();
        
        $fRepo = $em->getRepository('CoreBundle:Flags');
        $fQuery = $fRepo->createQueryBuilder('f')
                 ->where('f.flagType=:type')
                 ->setParameter('type','PS')->getQuery();
        $flags = $fQuery->getResult();
        
        $pRepo = $em->getRepository('CoreBundle:Project'); 
        $query = $pRepo->createQueryBuilder('p')
                ->leftJoin('p.tasks','t')
                ->addSelect('t')
                /* ->leftJoin('p.invoices','i')
                ->addSelect('i')
                ->leftJoin('i.item','it')
                ->addSelect('it') */
                ->orderBy('p.projectName','DESC')->getQuery(); 
                        
        // $start = microtime(true);
        $projects = $query->getResult();
        /* $total = microtime(true) - $start;
        echo $total; */
        
        // Invoicing stats
        $openArray = array();
        $openSum = 0;
        $invoiceArray = array();
        $invoiceSum = 0;
        $reminderArray = array();
        $remindSum = 0;
        $incompleteArray = array();
        $incompleteSum = 0;

        $activeTasks = array();
        
        $now = new \DateTime();
        
        $projectArray =array();
        
        foreach( $projects as $project ){
            $open = false;
            $toInvoice = false;
            $toRemind = false;
            
            $projectTotal = $project->getProjectPrice();

            foreach( $project->getInvoices() as $invoice ){
                if( $invoice->getType() != "Q" ) {
                    $projectTotal -= $invoice->getAmount();
                
                    $iDate = $invoice->getInvoiced();
                    $rDate = $invoice->getReminder();
                    if( $rDate && $rDate > $iDate) {
                        $iDate = $rDate;
                    }
                    $remDate = $iDate;
                    if( $remDate ){
                        $remDate->modify('+30 days');
                    }
                    $pDate = $invoice->getPaid();
            
                    if( $iDate && $remDate > $now && !$pDate ) {
                        $open = true;
                        $openSum += $invoice->getAmount();
                    }
                    if( !$iDate ) {
                        $toInvoice = true;
                        $invoiceSum += $invoice->getAmount();
                    }
                    
                    if( $iDate && !$pDate && $remDate < $now ){
                        $toRemind = true;
                        $remindSum += $invoice->getAmount();
                    }
                }
            } 
               
            if( $open ) {
                $openArray[ $project->getProjectName() ] = $project;
            }
            if( $toInvoice ){
                $invoiceArray[ $project->getProjectName() ] = $project;
            }
            if( $toRemind ){
                $reminderArray[ $project->getProjectName() ] = $project;
            }
            if( $projectTotal > 0 ){
                $incompleteArray[ $project->getProjectName() ] = $project;
                $incompleteSum += $projectTotal;
            }
            
            $thisMonth =  new \DateTime();
            $thisMonth->modify('+30 days');
            foreach( $project->getTasks() as $task) {
                if( $task->getTarget() <= $thisMonth && ! $task->getFinalize() ) {
                    
                    $tDetails = array( 'id' => $project->getId(),
                                       'pName' => $project->getProjectName(),
                                       'tName' => $task->getName(),
                                       'target' => $task->getTarget()
                            );
                    
                    $activeTasks[] = $tDetails;
                    
                }
            }            
        }

        $connection = $this->get('database_connection');
        $stats = $connection->fetchAll('select f.flaglabel "label", count(*) "count" from CoreFlags f join CoreProject p on f.id = p.projectStatus_id where f.flagType="PS" group by f.flaglabel');
        
        $dateArray = array();
        $month = new \DateTime(); 
        for( $n=0; $n<=12; $n++) {
            $dateArray[ $month->format( 'Y-m') ] = $month->format( 'm/Y');
            $month->modify( '-1 months');
            
        }
        
        // select p.`projectName`, p.`projectPrice`, sum(i.`amount`) from project p left join invoicing i on p.`id`=i.`project_id` where i.`invoice`=1 group by p.`projectName`, p.`projectPrice` having  p.`projectPrice` > sum(i.`amount`) 
        
        // select p.`projectName`, COALESCE(p.`projectPrice`,0) "amount", sum(COALESCE(i.`amount`,0)) "invoiced" from project p left join invoicing i on p.`id`=i.`project_id` group by p.`projectName`, p.`projectPrice` having COALESCE( p.`projectPrice`,0) > sum(COALESCE(i.`amount`,0)) 
        
        return array( 
            'flags' => $flags,
            'projects' => $projects,
            'stats' => $stats,
            'openInvoice' => $openArray,
            'openSum' => $openSum,
            'toInvoice' => $invoiceArray,
            'invoiceSum' => $invoiceSum,
            'toRemind' => $reminderArray,
            'remindSum' => $remindSum,
            'incomplete' => $incompleteArray,
            'incompleteSum' => $incompleteSum,
            'activeTasks' => $activeTasks,
            'months' => $dateArray );
    }
    
    /**
     * @Route( "/gestion/main2", name="_gestion_main2")
     * @Template
     */
     public function indexTwoAction()
     {
        $em = $this->get('doctrine')->getManager();
        
        $repo = $em->getRepository('CoreBundle:Flags');
        $fQuery = $repo->createQueryBuilder('f')
                 ->where('f.flagType=:type')
                 ->setParameter('type','PS')->getQuery();
        $flags = $fQuery->getResult();
        return array( 
            'flags' => $flags );
     }
    
    /**
     * @Route( "/gestion/suivi", name="_gestion_suivi" )
     * @Template
     */
    public function suiviAction(){
        $em = $this->get('doctrine')->getManager();    
        $repo = $em->getRepository('CoreBundle:Project');
        $query = $repo->createQueryBuilder('p')
                ->where('p.projectStatus not in (1,5)')
                ->orderBy('p.projectName','DESC')->getQuery();
        $projects = $query->getResult();
        
        return array( 'projects' => $projects );
    }
    
    
    /**
     * @Route( "/gestion/project/{id}", name="_gestion_project" )
     * @Template
     */
    public function projectAction( Request $request, Project $project){
        $em = $this->get('doctrine')->getManager();    
        
        $form = $this->get('form.factory')
            ->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $project)
            ->add('projectName','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('projectBudget','Symfony\Component\Form\Extension\Core\Type\NumberType')
            ->add('projectPrice','Symfony\Component\Form\Extension\Core\Type\NumberType')
            ->add('projectStart','Symfony\Component\Form\Extension\Core\Type\DateType', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'
                ))
            ->add('projectEnd','Symfony\Component\Form\Extension\Core\Type\DateType', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'
                ))
            ->add('authDate','Symfony\Component\Form\Extension\Core\Type\DateType', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'
                ))
            ->add('workStart','Symfony\Component\Form\Extension\Core\Type\DateType', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'
                ))
            ->add('projectDesc','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('projectNote', 'Symfony\Component\Form\Extension\Core\Type\TextareaType')
            ->add('projectType','Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                  'class' => 'CoreBundle:Flags',
                  'placeholder' => '-',
                  'query_builder' => function( EntityRepository $er ) {
                    return $er->createQueryBuilder('f')->where('f.flagType=\'PT\'')->orderBy('f.flagLabel','ASC');
                  },
                  'choice_label' => 'flagLabel' ))
            ->add('projectStatus','Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                  'placeholder' => '-',
                  'class' => 'CoreBundle:Flags',
                  'query_builder' => function( EntityRepository $er ) {
                    return $er->createQueryBuilder('f')->where('f.flagType=\'PS\'')->orderBy('f.flagLabel','ASC');
                  },
                  'choice_label' => 'flagLabel' ))
            ->add('projectContract','Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                  'placeholder' => '-',
                  'class' => 'CoreBundle:Flags',
                  'query_builder' => function( EntityRepository $er ) {
                    return $er->createQueryBuilder('f')->where('f.flagType=\'CT\'')->orderBy('f.flagLabel','ASC');
                  },
                  'choice_label' => 'flagLabel' ))
            ->add('addressStreet1','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('addressStreet2','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('addressCP','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('addressCity','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('addressCountry','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('cadastre','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('section','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('commune','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->getForm();

        
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
              
                // Persist project
                $em = $this->get('doctrine')->getManager();
                $em->persist($project);
                $em->flush();
            
                // return $this->redirect($this->generateUrl('_admin_user_success',array( 'login' => $user->getLogin(), 'action' => 'cree')));
            }
        } 
        
        return array( 
            'form' => $form->createView(),
            'project' => $project );
    }    
    
    /**
     * @Route( "/gestion/project/tasks/{id}", name="_gestion_project_tasks" )
     * @Template 
     */
    public function projectTasksAction( Project $project ){        
        $em = $this->get('doctrine')->getManager();    
      
        return array(
             'project' => $project,
        );
    }
    
    /**
     * @Route( "/gestion/project/suivi/{id}", name="_gestion_project_suivi", defaults={ "id"=0 } )
     * @Template
     */
    public function projectSuiviAction( Project $project ){
        $em = $this->get('doctrine')->getManager();    
        
        // Build user list
        $repo = $em->getRepository('CoreBundle:User');
        $query = $repo->createQueryBuilder('u')
                ->orderBy('u.lastname','ASC')->getQuery();
        $users = $query->getResult();
                      
        return array(
            'project' => $project,
            'users' => $users,
        );
    }

    /**
     * @Route( "/gestion/project/trajets/{id}", name="_gestion_project_trajets", defaults={ "id"=0 } )
     * @Template
     */
    public function projectTrajetsAction( Project $project ){
        $em = $this->get('doctrine')->getManager();    
       
        // Build user list
        $repo = $em->getRepository('CoreBundle:User');
        $query = $repo->createQueryBuilder('u')
                ->orderBy('u.lastname','ASC')->getQuery();
        $users = $query->getResult();
                
        $hours = 0;
        $minutes = 0;
              
        foreach( $project->getTimeLogs() as $timelog ) {
            
            $hours += $timelog->getHours();
            $minutes += $timelog->getMinutes();
        }
        
        $carry = floor($minutes / 60);
        $hours += $carry;
        $minutes = $minutes - ($carry*60);
        
        $total = sprintf( "%02d:%02d", $hours, $minutes );
        
        return array(
            'project' => $project,
            'users' => $users,
            'total' => $total
        );
    }
    
    
    
    /**
     * @Route( "/gestion/factures", name="_gestion_factures" )
     * @Template
     */
    public function facturesAction(){
        return array();
    }
    
    /**
     * @Route( "/gestion/devis", name="_gestion_quotes" )
     * @Template
     */
    public function quotesAction(){
        return array();
    }    

    /**
     * @Route( "/gestion/trajets", name="_gestion_trajets" )
     * @Template
     */
    public function trajetsAction(){
        return array();
    }
    
    
    
    /**
     * @Route( "/gestion/factures/delete", name="_invoice_ajax_delete" )
     */
    public function deleteFactureAction( Request $request ) {
        $iId = $request->get('id');
        
        if( $iId ) {
            $em = $this->get('doctrine')->getManager();
            $repo = $em->getRepository('ProjectManagementBundle:Invoice');
            
            $invoice = $repo->findOneByNumber( $iId );
          
            if( $invoice ) {
                
                foreach( $invoice->getItems() as $item ) {
                    $invoicing = $item->getInvoicing();
                    if( $invoicing ){
                        $invoicing->setInvoiced(null);
                    }
                    $em->remove( $item );
                }
                
                $em->remove( $invoice );
                $em->flush();
            
                $returnArray = array( "response" => 200 );
            } else {
                $returnArray = array( "response" => 500 );                        
            }
        } else {
            $returnArray = array( "response" => 500 );            
        }
        
        $return = json_encode( $returnArray );
        return new Response( $return, 200);              
    }
    
    /**
     * @Route( "/gestion/project/facturation/{id}", name="_gestion_project_facturation", defaults={ "id"=0 } )
     * @Template
     */
    public function projectFacturationAction( Project $project ){        
         return array(
            'project' => $project
        );
          
    }
    
    /**
     * @Route( "/gestion/project/devis/{id}", name="_gestion_project_devis", defaults={ "id"=0 } )
     * @Template
     */
    public function projectQuoteAction( Project $project ){
         return array(
            'project' => $project
        );
          
    }    
    
    /**
     * @Route( "/gestion/project/journal/{id}", name="_gestion_project_journal" )
     * @Template
     */
    public function projectJournalAction( Project $project ){
        $em = $this->get('doctrine')->getManager();    

        // Build action list
        $flagRepo = $em->getRepository('CoreBundle:Flags');
        $query = $flagRepo->createQueryBuilder('f')
                ->where('f.flagType=\'LB\'')->orderBy('f.flagLabel','ASC')->getQuery();
        $flags = $query->getResult();

        // Build user list
        $userRepo = $em->getRepository('CoreBundle:User');
        $userQuery = $userRepo->createQueryBuilder('u')
                ->where('u.enabled=1 and not u.role=\'ROLE_USER\' ')->orderBy('u.lastname','ASC')->getQuery();
        $users = $userQuery->getResult();        
        
        return array(
            'project' => $project,
            'actions' => $flags,
            'users' => $users
        );
        
    }
    
}
