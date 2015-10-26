<?php

namespace ESN\MembersBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use ESN\MembersBundle\Form\Handler\ErasmusHandler;
use ESN\MembersBundle\Form\Type\ErasmusType;
use ESN\MembersBundle\Form\ErasmusUpdateType;
use ESN\MembersBundle\Form\Handler\EsnerHandler;
use ESN\MembersBundle\Form\Handler\SearchHandler;
use ESN\MembersBundle\Form\SearchType;
use ESN\MembersBundle\Form\Type\EsnerType;
use ESN\PermanenceBundle\Entity\ParticipateTrip;
use ESN\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class MembersController extends Controller
{   
    /**
     * Action à l'affichage de la page index.html.twig
     * Affiche sur la page : 
     *  - titre de la page
     *  - action : lister,detailler,editer
     *  - id : id du membre s'il s'agit d'une action detailler ou editer
     *
     * @param integer $user_id
     *
     * @return type
     */
    public function detailEsnerAction($user_id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository('ESNUserBundle:User')->find($user_id);

        if (!$user){
            throw new NotFoundResourceException("No ESNer with this ID");
        }

        /** @var ArrayCollection $participatetrips */
        $participatetrips = $em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findBy(array("user" => $user));
        $trips = new ArrayCollection();

        /** @var ParticipateTrip $participatetrip */
        foreach($participatetrips as $participatetrip){
            if (!$trips->contains($participatetrip->getTrip()))
                $trips->add($participatetrip->getTrip());
        }

        return $this->render('ESNMembersBundle:Esners:detail.html.twig', array(
                'trips'=> $trips,
                'user' => $user
            )
        );
    }

    /**
     * Action à l'affichage de la page index.html.twig
     * Affiche sur la page :
     *  - titre de la page
     *  - action : lister,detailler,editer
     *  - id : id du membre s'il s'agit d'une action detailler ou editer
     *
     * @param type $user_id
     *
     * @return type
     */
    public function detailErasmusAction($user_id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository('ESNUserBundle:User')->find($user_id);

        if (!$user){
            throw new NotFoundResourceException("No Erasmus with this ID");
        }

        /** @var ArrayCollection $participatetrips */
        $participatetrips = $em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findBy(array("user" => $user));
        $trips = new ArrayCollection();

        /** @var ParticipateTrip $participatetrip */
        foreach($participatetrips as $participatetrip){
            if (!$trips->contains($participatetrip->getTrip()))
                $trips->add($participatetrip->getTrip());
        }

        return $this->render('ESNMembersBundle:Erasmus:detail.html.twig', array(
                'trips'=> $trips,
                'user' => $user
            )
        );
    }

    /**
     * List Esner
     *
     * @return type
     */
    public function listEsnerAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $where = array("esner" => 1);
        if (!$this->getUser()->hasPermissionFor('human-ressources'))
            $where["active"] = 1;

        $esners = $em->getRepository('ESNUserBundle:User')->findBy($where, array("firstname" => "ASC", "lastname" => "ASC"));

        return $this->render('ESNMembersBundle:Esners:list.html.twig',  array(
            'esners' => $esners
        ));
    }//listAction

    /**
     * List Erasmus
     *
     * @return type
     */
    public function listErasmusAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $where = array("esner" => 0);

        $users = $em->getRepository('ESNUserBundle:User')->findBy($where, array("firstname" => "ASC", "lastname" => "ASC"));

        return $this->render('ESNMembersBundle:Erasmus:list.html.twig',  array(
            'users' => $users
        ));
    }

    /**
     * Delete a user
     *
     * @param integer $user_id
     */
    public function deleteAction($user_id)
    {
        if (!$this->getUser()->hasPermissionFor('human-ressources')){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository('ESNUserBundle:User')->find($user_id);

        if (!$user) {
            throw $this->createNotFoundException('No User found');
        }

        $em->remove($user);
        $em->flush();

        $this->get('request')->getSession()->getFlashBag()->add('notice', 'User supprimé');

        return $this->redirect($this->generateUrl('esn_members_esner'));
    }//deleteAction
    
    /**
     * Action à l'affichage de la page d'édition d'un membre en fonction
     * du type du membre et de son ID.
     *
     * @param Request $request
     * @param integer $user_id
     *
     * @throws createAccessDeniedException
     */
    public function editEsnerAction(Request $request, $user_id)
    {
        if (!$this->getUser()->hasPermissionFor('human-ressources')){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository('ESNUserBundle:User')->find($user_id);

        if (!$user){
            throw new NotFoundResourceException("No ESNer with this ID");
        }

        $trips = $em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findBy(array("user" => $user));

        $form = $this->get('form.factory')->create(new EsnerType($em, "update"), $user);

        $formHandler = new EsnerHandler($em, $form, $request, $this->container, $this->get('templating'), $this->get('mailer'));
        $form->handleRequest($request);

        if ($formHandler->process()){
            return $this->redirect($this->generateUrl('esn_members_detail', array(
                'trips'=> $trips,
                'user_id'=>$user_id
            )));
        }

        return $this->render("ESNMembersBundle:Esners:edit.html.twig", array(
                "user" => $user,
                "form" => $form->createView()
            )
        );
    }//editAction

    /**
     * Action à l'affichage de la page d'édition d'un membre en fonction
     * du type du membre et de son ID.
     *
     * @param integer $user_id
     */
    public function editErasmusAction(Request $request, $user_id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getDoctrine()->getManager()->getRepository('ESNUserBundle:User')->find($user_id);

        if (!$user){
            throw new NotFoundResourceException("No Erasmus with this ID");
        }

        $form = $this->get('form.factory')->create(new ErasmusType($em), $user);
        $formHandler = new ErasmusHandler($em, $form, $request);
        $form->handleRequest($request);

        if ($formHandler->process()){
            return $this->redirect($this->generateUrl('esn_members_erasmus_detail', array(
                'user_id' => $user_id
            )));
        }

        return $this->render("ESNMembersBundle:Erasmus:edit.html.twig", array(
                "form" => $form->createView()
            )
        );

    }//editAction

    /**
     * Create Erasmus
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createErasmusAction(Request $request) {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = new User();

        $form = $this->get('form.factory')->create(new ErasmusType($em), $user);
        $formHandler = new ErasmusHandler($em, $form, $request);

        $form->handleRequest($request);

        if ($formHandler->process())
        {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'l\'Erasmus ' . $user . ' a bien été créé'
            );

            return $this->redirect($this->generateUrl('esn_members_erasmus', array(
                'type'=>'erasmus'
            )));
        }

        return $this->render('ESNMembersBundle:Erasmus:edit.html.twig',
            array(
                'form' => $form->createView(),
                'hasError' => $request->getMethod() == 'POST' && !$form->isValid()
            ));
    }

    /**
     * Create ESNer Action
     *
     * @param Request $request
     *
     * @throws createAccessDeniedException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createEsnerAction(Request $request) {

        if (!$this->getUser()->hasPermissionFor('human-ressources')){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = new User();

        $form = $this->get('form.factory')->create(new EsnerType($em, "create"), $user);
        $formHandler = new EsnerHandler($em, $form, $request, $this->container, $this->get('templating'), $this->get('mailer'));
        $form->handleRequest($request);

        if ($formHandler->process())
        {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'l\'ESNer ' . $user . ' a bien été créé'
            );
            return $this->redirect($this->generateUrl('esn_members_esner'));
        }

        return $this->render('ESNMembersBundle:Esners:edit.html.twig',
            array(
                'form' => $form->createView(),
                'hasError' => $request->getMethod() == 'POST' && !$form->isValid()
            )
        );
    }
}
