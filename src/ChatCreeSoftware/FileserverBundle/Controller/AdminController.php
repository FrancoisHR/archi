<?php

namespace ChatCreeSoftware\FileserverBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    
    /**
     * @Route( "/projets/admin/creation_projet", name="_admin_create_project")
     * @Template
     */ 
    public function createProjectAction( Request $request)
    {
        $project = new Project();

        $form = $this->get('form.factory')
            ->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $project)
            ->add('projectName','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ( $form->isSubmitted() && $form->isValid() ) {
                
                $project->createPath( $project->getProjectName() );
            
                // Persist user
                $em = $this->get('doctrine')->getManager();
                $em->persist($project);
                $em->flush();              
                
                // Create directory
                mkdir( $project->getProjectPath(), 0705 );
            
                return $this->redirect($this->generateUrl('_admin_project_createSuccess'));
            }
        }
        
        return array(
            'form' => $form->createView(),
                );
    }
    
    /**
     * @Route("/projets/admin/succes_creation_projet", name="_admin_project_createSuccess" )
     * @Template
     */
    public function createProjectSuccessAction()
    {
        return array();
    }    
}