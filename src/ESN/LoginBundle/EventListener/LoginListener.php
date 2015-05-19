<?php
/**
 * Created by PhpStorm.
 * User: Jérémie Samson | jeremie@ylly.fr
 * Date: 19/05/15
 * Time: 14:51
 */

namespace ESN\LoginBundle\EventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class LoginListener {

    private $router;

    public function __construct($router){
        $this->router       = $router;
    }

    public function onKernelRequest(GetResponseEvent $event){
        $request = $event->getRequest();
        $session = $event->getRequest()->getSession();

        if ($session->get('user') == null){
            if($request->get('_route') != null
                && $request->get('_route') != "esn_login_homepage"
                && $request->get('_route') != "esn_login_check"){
                $event->setResponse(new RedirectResponse($this->router->generate('esn_login_homepage')));
            }
        }
    }

}