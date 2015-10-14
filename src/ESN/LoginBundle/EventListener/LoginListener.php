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
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\SecurityContext;

class LoginListener {

    /**
     * @var Router
     */
    private $router;

    /**
     * @var SecurityContext
     */
    private $securityContext;

    public function __construct(Router $router, SecurityContext $securityContext){
        $this->router       = $router;
        $this->securityContext = $securityContext;
    }

    public function onKernelRequest(GetResponseEvent $event){
        $request = $event->getRequest();
        $session = $event->getRequest()->getSession();

        if (!$this->securityContext->getToken()->getUser()){
            if($request->get('_route') != null
                && $request->get('_route') != "esn_login_homepage"
                && $request->get('_route') != "esn_login_check"
                && $request->get('_route') != "fos_user_security_login"){
                $event->setResponse(new RedirectResponse($this->router->generate('esn_login_homepage')));
            }
        }
    }

}