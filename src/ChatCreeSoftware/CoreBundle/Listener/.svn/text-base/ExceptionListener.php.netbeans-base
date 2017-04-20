<?php

namespace ChatCreeSoftware\CoreBundle\Listener;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    protected $templating;
    protected $kernel;
    
    public function __construct( EngineInterface $templating, $kernel )
    {
        $this->templating = $templating;
        $this->kernel = $kernel;
    }
    
    public function onKernelException( GetResponseForExceptionEvent $event)
    {        
        // Enhanced error page for prod environment
        if( $this->kernel->getEnvironment() == 'prod' )
        {
            $exception = $event->getException();
            
            $response = new Response();
            $response->setContent(
                    $this->templating->render( 'CoreBundle:Exception:exception.html.twig', array( 'exception' => $exception ))
                    );

            // HttpExceptionInterface is a special type of exception that holds status code and header details
            if( $exception instanceof HttpExceptionInterface )
            {
                $response->setStatusCode( $exception->getStatusCode());
                $response->headers->replace( $exception->getHeaders());
            } else {
                $response->setStatusCode(500);
            }
            $event->setResponse($response);
        }
    }
}
