<?php

namespace ChatCreeSoftware\ProjectManagementBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * @Route("/gestion/reports", name="_gestion_reports")
     * @Template
     */
    public function reportsAction()
    {
        
        return array();
    }
    
    /**
     * @Route("/gestion/reports/kmannuel", name="_gestion_annual_km")
     * @Template
     */
    public function kmAnnuelAction()
    {
        $em = $this->get('doctrine')->getManager();
                
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');                
        
        $userQuery = $em->createQuery( 'select distinct u from CoreBundle:User u JOIN u.journeys j' );
        $users = $userQuery->getResult();

        $yearsQuery = $em->createQuery( 'select distinct YEAR(j.date) from ProjectManagementBundle:Journey j' );
        $years = $yearsQuery->getResult();
                
        return array( "users" => $users,
                      "years" => $years );        
    }
    
    /**
     * @Route("/gestion/reports/kmannueldata/{user}/{year}", name="_gestion_annual_km_data")
     */
    public function kmAnnuelDataAction($user,$year)
    {
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('ProjectManagementBundle:Journey');

        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
        
        $query = $repo->createQueryBuilder('j')
                ->where( 'YEAR(j.date) = :date and j.user = :user')
                ->setParameter( 'date', $year )
                ->setParameter( 'user', $user )
                ->orderBy('j.date','ASC')->getQuery();
        $journeys = $query->getResult();
      
        $journeysArray = array();
        foreach ($journeys as $journey ) {
            $journeyObject = array(
            $journey->getDate()->format("d/m/Y"),
            $journey->getProject()->getProjectName(),
            $journey->getStart(),
            $journey->getEnd(),
            $journey->getDistance(),
            $journey->getDescription() );

            $journeysArray[] = $journeyObject;
        }
                
        $return = json_encode( array( "data" => $journeysArray ) );
        return new Response( $return, 200);   
        
    }
}