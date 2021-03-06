<?php

namespace ChatCreeSoftware\FileserverBundle\Controller;

use ChatCreeSoftware\CoreBundle\Entity\Email;
use ChatCreeSoftware\CoreBundle\Entity\User;
use ChatCreeSoftware\FileserverBundle\Forms\AceStorage;
use ChatCreeSoftware\FileserverBundle\Forms\EmailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;

/**
 * 
 */
class UserController extends Controller
{
    
    public static $recPerPage = 12;
    public static $maxPageDisplay = 10;

    /**
     * @Route( "/projets/admin/listUsers", name="_admin_list_users")
     * @Template
     */
    public function listUsersAction()
    {
        $em = $this->get('doctrine')->getManager();
        $repository = $em->getRepository('ChatCreeSoftware\CoreBundle\Entity\User');
        $query = $repository->createQueryBuilder('u')
                ->orderBy('u.login','ASC')->getQuery();
        $users = $query->getResult();
        
        return array( 'users' => $users );    
        
    }
    
    /**
     * @Route( "/projets/admin/createUser", name="_admin_user_create" )
     * @Template
     */
    public function createUserAction( Request $request)
    {
        $user = new User();
        $user->addEmails( new Email() );

        $form = $this->get('form.factory')
            ->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $user)
            ->add('enabled','Symfony\Component\Form\Extension\Core\Type\CheckboxType', array('label' => ' ', 'required' => false))
            ->add('company','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('title','Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'choices'   => User::getTitlesArray(),))
            ->add('firstname','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('lastname','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('login', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('password','Symfony\Component\Form\Extension\Core\Type\PasswordType')
            ->add('emails','Symfony\Component\Form\Extension\Core\Type\CollectionType',array(
                    'entry_type' => EmailType::class,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'prototype'     => true,
                    ))
            ->add('role','Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'choices'   => User::getRolesArray(),) )
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                // Encode the password with the encoder defined in security.yml
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);
 
               // hack to work around bindRequest not using class methods to populate data
                foreach( $user->getEmails() as $mail ) {
                    $mail->setUser( $user );
                }
                
                // Persist user
                $em = $this->get('doctrine')->getManager();
                $em->persist($user);
                $em->flush();
            
                return $this->redirect($this->generateUrl('_admin_user_success',array( 'login' => $user->getLogin(), 'action' => 'cree')));
            }
        }
        
        return array(
            'form' => $form->createView(),
                );
    }
    
    /**
     * @Route("/projets/admin/{login}/{action}UserSuccess", name="_admin_user_success" )
     * @Template
     */
    public function userSuccessAction( $login, $action)
    {
        
        return array(
            'login' => $login,
            'action' => $action
        );
    }
    
    /**
     * @Route("/projets/admin/editUser/{login}", name="_admin_user_edit" )
     * @Template
     */
    public function editUserAction( Request $request, User $user){
        $em = $this->get('doctrine')->getManager();

        $form = $this->get('form.factory')
            ->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $user)
            ->add('enabled','Symfony\Component\Form\Extension\Core\Type\CheckboxType', array('required' => false))
            ->add('company','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('title','Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'choices'   => User::getTitlesArray(),))
            ->add('firstname','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('lastname','Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('login', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('emails','Symfony\Component\Form\Extension\Core\Type\CollectionType',array(
                    'entry_type' => 'ChatCreeSoftware\FileserverBundle\Forms\EmailType',
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'prototype'     => true,
                ))
            ->add('role','Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'choices'   => User::getRolesArray() ,) )
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            // if ($form->isSubmitted() && $form->isValid()) {
            
                // hack to work around bindRequest not using class methods to populate data
                foreach( $user->getEmails() as $mail ) {
                    $em->persist($mail);
                    $mail->setUser( $user );
                }
                
                // Persist user
                $em->persist($user);
                $em->flush();
            
                return $this->redirect($this->generateUrl('_admin_user_success',array( 'login' => $user->getLogin(), 'action' => 'modifie')));
            // }
        }
        
        return array(
            'form' => $form->createView(),
            'user' => $user   );        
    }
    
    /**
     * @Route("/projets/admin/password/{login}", name="_admin_user_password" )
     * @Template
     */
    public function changePasswordAction( Request $request, User $user ) {
        $em = $this->get('doctrine')->getManager();

        $form = $this->get('form.factory')
            ->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $user)
            ->add('password','Symfony\Component\Form\Extension\Core\Type\PasswordType')
            ->getForm();        

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                
                // Encode the password with the encoder defined in security.yml
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);

                // Persist user
                $em->persist($user);
                $em->flush();
            
                return $this->redirect($this->generateUrl('_admin_list_users'));
            }
        }
                
        return array(
            'form' => $form->createView(),
            'user' => $user   );        
    }
    
    /**
     * @Route("/projets/admin/audit/{login}", name="_admin_user_audit" )
     * @Template
     */
    public function auditUserAction( User $user ) {
        $em = $this->get('doctrine')->getManager();
        
        return array(
            'user' => $user,
        );
    }
    
    /**
     * @Route("/projets/admin/delete/{login}", name="_admin_user_delete" )
     * @Template
     */
    public function askDeleteUserAction( User $user ) {
        $em = $this->get('doctrine')->getManager();
        
        return array(
            "user" => $user,
        );
    }
    
    /**
     * @Route("/projets/admin/deleteResult/{login}", name="_admin_user_delete_result" )
     * @Template
     */
    public function deleteUserAction( User $user ){
        $em = $this->get('doctrine')->getManager();
        
        // keep the login
        $login = $user->getLogin();
                
        $em->remove( $user );
        $em->flush();
        
        return array(
            "login" => $login
        );
    }
    
    /**
     * @Route("/projets/admin/deleteMail/{login}/{mail}", name="_admin_user_delete_mail")
     * @Template
     */
    public function askDeleteMailAction( $login, $mail ){
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('CoreBundle:Email');
        $mail = $repo->findOneById( $mail );        
        
        return( array(
            "user" => $login,
            "mail" => $mail
        ));
    }
    
    
    /**
     * @Route("/projets/admin/deleteMailResult/{login}/{mail}", name="_admin_user_mail_delete_result")
     * @Template
     */
    public function deleteMailAction( $login, $mail ){
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('CoreBundle:Email');
        $mail = $repo->findOneById( $mail );        
        
        $mailAddress = $mail->getMail();
        
        $em->remove( $mail );
        $em->flush();
        
        return( array(
            "login" => $login,
            "mail" => $mailAddress
        ));        
    }
    
    /**
     * @Route("/projets/admin/lastlogins", name="_admin_last_user_login" ) 
     * @Template
     */
    public function listLastLoginsAction( ){
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('CoreBundle:Log');
        
        $query = $repo->createQueryBuilder('l')
                ->where( "l.timestamp > :date")
                ->setParameter( 'date', new \DateTime('-12 months'))
                ->orderBy( 'l.timestamp')
                ->getQuery();
        
        $logs = $query->getResult();

       return array(
           "logs" => $logs
       );
    }
    
    /**
     * @Route("/projets/admin/access/{login}", name="_admin_user_access" )
     * @Template
     */
    public function listUserAccessAction( $login ){
        $em = $this->getDoctrine();
        
        $repo = $em->getRepository('CoreBundle:Project');
        $projects = $repo->findAll();

        $userProjects = array();
        
        foreach ($projects as $project) {
            // get the project acl
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($project);
                        
            try {
                $acl = $aclProvider->findAcl($objectIdentity);
            }
            catch( AclNotFoundException $e ) {
                echo $e->message();
            }
            
            foreach ($acl->getObjectAces() as $aceEntry) {

                if( $aceEntry->getSecurityIdentity()->getUsername() == $login )
                    $userProjects[] = array( "name" => $project->getProjectName(),
                                             "access" => AceStorage::$ace_map[ $aceEntry->getMask() ] );
            }

            
        }
        
        return array(
            "login" => $login,
            "projects" => $userProjects
        );
    }
}
?>
