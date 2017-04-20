<?php

namespace ChatCreeSoftware\CoreBundle\Security\Authorization;

use ChatCreeSoftware\CoreBundle\Entity\Log,
    Doctrine\ORM\EntityManager,
    Symfony\Bundle\TwigBundle\TwigEngine,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Routing\RouterInterface,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\Security\Core\Security,
    Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginAudit implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface {

    use \Symfony\Component\Security\Http\Util\TargetPathTrait;
    
    protected $router;
    protected $em;
    protected $templating;
    protected $defaultPath;

    public function __construct(EntityManager $em, TwigEngine $templating, RouterInterface $router, $defaultPath ) {
        $this->router = $router;
        $this->em = $em;
        $this->templating = $templating;
        $this->defaultPath = $defaultPath;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        $targetPath = $this->getTargetPath($request->getSession(), "fileserver");
        if( ! $targetPath ){
            $targetPath = $this->defaultPath;
        }
        
        $user = $token->getUser();
        $ip = $request->server->get('REMOTE_ADDR');             
       
        $log = new Log("Login");
        $log->setUser($user);
        $log->setIp($ip);

        $this->em->persist($log);
        $this->em->flush();
        
        return new RedirectResponse($targetPath);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        $login = $request->get('_username');
        $pwd = $request->get('_password');

        if ($login) {
            $repo = $this->em->getRepository('CoreBundle:User');
            $user = $repo->findOneByLogin($login);

            $log = new Log("Echec Login");
            $log->setIp( $request->server->get('REMOTE_ADDR') );
            if ($user) {
                $log->setUser($user);
            } else {
                $log->setDetail("Tentative Login : $login/$pwd");
            }
            $this->em->persist($log);
            $this->em->flush();
        }

        // Use the injected templating service to render directly the login page
        $response = $this->templating->renderResponse("CoreBundle:Security:login.html.twig", array(
            'last_username' => $request->getSession()->get(Security::LAST_USERNAME),
            'error'         => true,
        ), null);
        
        return $response;
    }
}