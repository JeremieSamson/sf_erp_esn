<?php

namespace ESN\LoginBundle\Controller;

use ESN\LoginBundle\Security\User\UserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('ESNLoginBundle::index.html.twig');
    }

    public function checkAction(Request $request){
        $user = null;

        $cas_host = $this->container->getParameter('cas_server');
        $cas_port = $this->container->getParameter('cas_port');
        $cas_context = $this->container->getParameter('cas_path');

        $up = new UserProvider();
        $user = $up->loadUser($cas_host, $cas_port, $cas_context);

        if ($user != null){
            $session = $this->container->get('session');
            $session->set('user', $user);

            return $this->redirect($this->generateUrl('esn_dashboard_homepage'));
        }

        $this->redirect($this->generateUrl('esn_login_homepage'));
    }
    public function logoutAction(Request $request){
        $session = $this->container->get('session');
        $session->remove('user');

        return $this->redirect($this->generateUrl('esn_login_homepage'));
    }
}
