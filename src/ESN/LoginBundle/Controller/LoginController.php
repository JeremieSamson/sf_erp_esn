<?php

namespace ESN\LoginBundle\Controller;

use ESN\AdministrationBundle\Manager\ActivityManager;
use ESN\LoginBundle\Security\User\UserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\User;
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
        $em = $this->getDoctrine()->getEntityManager();
        $user_cas = null;

        $cas_host = $this->container->getParameter('cas_server');
        $cas_port = $this->container->getParameter('cas_port');
        $cas_context = $this->container->getParameter('cas_path');

        $up = new UserProvider();

        $user_cas = $up->loadUser($cas_host, $cas_port, $cas_context);

        if ($user_cas != null){

            $user_db = $em->getRepository("ESNUserBundle:User")->findOneBy(array("username" => $user_cas->getEmail()));
            //$user_db = $em->getRepository("ESNUserBundle:User")->find(407);

            //Check sur le prénom & le nom
            if (!$user_db){
                $user_db = $em->getRepository("ESNUserBundle:User")->findOneBy(array("firstname" => $user_cas->getFirstname(), "lastname" => $user_cas->getLastname()));
            }

            $token = new UsernamePasswordToken($user_db, null, "main", $user_db->getRoles());
            $this->get("security.context")->setToken($token);

            $this->get('activity.manager')->login();

            /** @var Request $request */
            $request = $this->get("request");
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $this->redirect($this->generateUrl('esn_dashboard_homepage'));
        }

        return $this->redirect($this->generateUrl('esn_login_homepage'));
    }

    public function logoutAction(){
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        $this->get('activity.manager')->logout();

        return $this->redirect($this->generateUrl('esn_login_homepage'));
    }
}
