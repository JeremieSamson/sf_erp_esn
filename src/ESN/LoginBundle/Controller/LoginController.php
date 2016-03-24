<?php

namespace ESN\LoginBundle\Controller;

use ESN\AdministrationBundle\Manager\ActivityManager;
use ESN\LoginBundle\Security\User\UserProvider;
use ESN\UserBundle\Entity\User;
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
        $em = $this->getDoctrine()->getEntityManager();
        $user_cas = null;

        $cas_host = $this->container->getParameter('cas_server');
        $cas_port = $this->container->getParameter('cas_port');
        $cas_context = $this->container->getParameter('cas_path');

        if (isset($_SERVER['HTTP_CLIENT_IP'])
            || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
            || !(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1')) || php_sapi_name() === 'cli-server')
        ) {
            /** @var UserProvider $up */
            $up = new UserProvider($cas_host, $cas_context, $cas_port);

            $user_cas = $up->loadUser($cas_host, $cas_port, $cas_context);
        }else{
            /** @var User $user_db */
            $user_db = $em->getRepository("ESNUserBundle:User")->findOneByUsername("marie.mullier@hotmail.fr");

            $token = new UsernamePasswordToken($user_db, null, "main", $user_db->getRoles());
            $this->get("security.context")->setToken($token);

            $this->get('activity.manager')->login();

            /** @var Request $request */
            $request = $this->get("request");
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $this->redirect($this->generateUrl('esn_dashboard_homepage'));
        }

        if ($user_cas != null){

            $user_db = $em->getRepository("ESNUserBundle:User")->findOneBy(array("username" => $user_cas->getEmail()));

            //Check sur le prénom & le nom
            if (!$user_db)
                $user_db = $em->getRepository("ESNUserBundle:User")->findOneBy(array("firstname" => $user_cas->getFirstname(), "lastname" => $user_cas->getLastname()));

            $user = (!$user_db) ? new User() : $user_db;

            $user->setUsername($user_cas->getEmail());
            $user->setUsernameCanonical($user_cas->getEmail());
            $user->setEmail($user_cas->getEmail());
            $user->setGalaxyRoles(implode(",", $user_cas->getRoles()));
            $user->setFirstname($user_cas->getFirstname());
            $user->setLastname($user_cas->getLastname());
            $user->setBirthdate(\DateTime::createFromFormat("d/m/Y", $user_cas->getBirthdate()));
            $user->setGender($user_cas->getGender());
            $user->setSection($user_cas->getSection());
            $user->setCodeSection($user_cas->getSc());
            $user->setGalaxyPicture($user_cas->getPicture());
            $user->setMobile($user_cas->getTelephone());

            if (!$user_db) {
                $user->setEnabled(true);
                $user->setEsner(true);
                $user->setUsername($user_cas->getEmail());
                $user->setUsernameCanonical($user_cas->getEmail());
                $user->setEmail($user_cas->getEmail());
                $user->setRoles(array('ROLE_USER'));
                $user->setRandomPassword();
                $em->persist($user);
            }

            $em->flush();

            $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
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
