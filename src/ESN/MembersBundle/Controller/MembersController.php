<?php

namespace ESN\MembersBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Form\Handler\EsnerHandler;
use ESN\MembersBundle\Form\ErasmusType;
use ESN\MembersBundle\Form\ErasmusUpdateType;
use ESN\MembersBundle\Form\Handler\SearchHandler;
use ESN\MembersBundle\Form\SearchType;
use ESN\MembersBundle\Form\Type\EsnerType;
use ESN\PermanenceBundle\Entity\ParticipateTrip;
use ESN\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @param type $user_id
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
     * Action à l'affichage de la liste des membres en fonction du type.
     * @param type $type
     * @return type
     */
    public function listAction($type)
    {
        $liste_membres = array(
            'liste_membres' => $this->getAllMembers($type)
        );

        if ($type == 'esners') {
            return $this->render('ESNMembersBundle:Esners:list.html.twig',  $liste_membres);
        } else {
            return $this->render('ESNMembersBundle:Erasmus:list.html.twig', $liste_membres);
        }
    }//listAction


    /**
     * Action à l'affichage de la liste des membres en fonction du type.
     * @param type $type
     * @return type
     */
    public function listEsnerAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $esners = $em->getRepository('ESNUserBundle:User')->findBy(array("esner" => 1));

        return $this->render('ESNMembersBundle:Esners:list.html.twig',  array(
            'esners' => $esners
        ));
    }//listAction
    
    /**
     * Action à l'affichage d'une card d'un esner.
     * @param type $member
     * @return type
     */
    public function cardEsnerAction($member) {
        return $this->render('ESNMembersBundle:Esners:card.html.twig', array(
            'member' => $member
        )); 
    }//cardEsnerAction
    
    /**
     * Action à l'affichage d'une card d'un Erasmus
     * @param type $member
     * @return type
     */
    public function cardErasmusAction($member) {
        return $this->render('ESNMembersBundle:Erasmus:card.html.twig', array(
            'member' => $member
        )); 
    }//cardErasmusAction
    
    /**
     * Action à l'affichage des détails du profil d'un membre en fonction
     * du type du membre et de son ID.
     * @param type $type
     * @param type $id
     * @return type
     */
    public function detailAction($type,$id)
    {
        $member = array(
           'member' => $this->getAllMembers($type, $id)
        );

        if ($type == 'esners') {
            return $this->render('ESNMembersBundle:Esners:detail.html.twig', $member);
        } else {
            return $this->render('ESNMembersBundle:Erasmus:detail.html.twig', $member);
        }
    }//detailAction

    /**
     * @param type $id
     */
    public function deleteAction($id)
    {
        if (!$id) {
            throw $this->createNotFoundException('No Erasmus found');
        }

        $this->get('request')->getSession()->getFlashBag()->add('notice', 'Erasmus deleted');

        $em = $this->getDoctrine()->getManager();
        $erasmus = $em->getRepository('ESNMembersBundle:Erasmus')->find($id);

        $em->remove($erasmus);
        $em->flush();

        return $this->redirect($this->generateUrl('esn_members_homepage', array(
            'type'=>'erasmus'
        )));
    }//deleteAction
    
    /**
     * Action à l'affichage de la page d'édition d'un membre en fonction
     * du type du membre et de son ID.
     *
     * @param integer $id
     */
    public function editEsnerAction(Request $request, $user_id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('ESNUserBundle:User')->find($user_id);

        if (!$user){
            throw new NotFoundResourceException("No ESNer with this ID");
        }

        $trips = $em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findBy(array("user" => $user));

        $form = $this->get('form.factory')->create(new EsnerType($em), $user);

        $formHandler = new \ESN\MembersBundle\Form\Handler\EsnerHandler($em, $form, $request);
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
     * @param type $id
     */
    public function editErasmusAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $erasmus= $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Erasmus')->find($id);
        $form = $this->get('form.factory')->create(new ErasmusUpdateType($em, $erasmus));
        $formHandler = new ErasmusUpdateHandler($em, $form, $request);
        $form->handleRequest($request);

        $process = $formHandler->process();

        if ($process){
            return $this->redirect($this->generateUrl('esn_members_detail', array(
                'type' => 'Erasmus',
                'id'=>$id
            )));
        }

        return $this->render("ESNMembersBundle:Erasmus:edit.html.twig", array(
                "member" => $this->getAllMembers("Erasmus", $id),
                "form" => $form->createView()
            )
        );

    }//editAction
    /**
     * Si ID est fourni, retourne le membre, sinon retourne tout les membres
     * Retourne 
     * @param type $type
     * @param type $id
     * @return array
     */
    private function getAllMembers($type,$id=null,$where=null) {
        $repositoryEsner      = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Esner');
        $repositoryErasmus    = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Erasmus');
        $repositoryMember     = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Member');
        $repositoryUniversity = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:University');
        $repositoryCountry    = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Country');
        $repositoryParticipateTrips = $this->getDoctrine()->getManager()->getRepository('ESNPermanenceBundle:ParticipateTrip');

        $list_member = array();
        if (!$id) {
            // Retourne un array avec 'esner':Object Esner, 'identity':Object Member
            if ($type == "esners") {
                $list_esner = $repositoryEsner->findWithSearch($where);
                foreach ($list_esner as $esner) {
                    $member = $repositoryMember->find($esner->getMember()->getId());
                    array_push($list_member,array('esner'=>$esner,'identity'=>$member));
                }
            } else {
            $list_erasmus = $repositoryErasmus->findAll();
                foreach ($list_erasmus as $erasmus) {
                    $member = $repositoryMember->find($erasmus->getMember()->getId());
                    array_push($list_member,array('erasmus'=>$erasmus,'identity'=>$member));
                }
            } 
        } else {
            if ($type == "esners") {
                $esner = $repositoryEsner->find($id); 
                $esner_identity = $esner->getMember();
                $esner_trips= $repositoryParticipateTrips->findByMember($esner->getMember());
                array_push($list_member,array('esner'=>$esner,'identity'=>$esner_identity,'trips'=>$esner_trips));
            } else {
                $erasmus = $repositoryErasmus->find($id);
                $erasmus_identity = $repositoryMember->find($erasmus->getMember()->getId());
                $erasmus_identity->setUniversity($repositoryUniversity->find($erasmus_identity->getUniversity()));
                $erasmus_identity->setNationality($repositoryCountry->find($erasmus_identity->getNationality()));
                array_push($list_member,array('erasmus'=>$erasmus,'identity'=>$erasmus_identity));  
            }
        }
        return $list_member;
    }
    
    public function createErasmusAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create(new ErasmusType($em));
        $formHandler = new ErasmusHandler($em, $form, $request);
        $form->handleRequest($request);

        $process = $formHandler->process();

        if ($process)
        {
            return $this->redirect($this->generateUrl('esn_members_homepage', array(
                'type'=>'erasmus'
            )));
        }

        return $this->render('ESNMembersBundle:Erasmus:form_create.html.twig',
            array(
                'form' => $form->createView(),
                'hasError' => $request->getMethod() == 'POST' && !$form->isValid()
            ));
    }//createErasmusAction
}
