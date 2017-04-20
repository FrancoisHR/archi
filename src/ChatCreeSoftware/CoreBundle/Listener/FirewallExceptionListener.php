<?php

namespace ChatCreeSoftware\CoreBundle\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Firewall\ExceptionListener as BaseExceptionListener;

class FirewallExceptionListener extends BaseExceptionListener
{
    use \Symfony\Component\Security\Http\Util\TargetPathTrait;

    protected function setTargetPath(Request $request)
    {
        // Do not save target path for XHR requests
        // You can add any more logic here you want
        // Note that non-GET requests are already ignored
        if ($request->isXmlHttpRequest()) {
            $this->saveTargetPath($request->getSession(), $this->providerKey, $request->headers->get('referer'));
        } else {
            parent::setTargetPath($request);
        }
    }
}