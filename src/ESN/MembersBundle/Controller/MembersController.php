<?php

namespace ESN\MembersBundle\Controller;

use ESN\MembersBundle\Form\ErasmusType;
use ESN\MembersBundle\Form\Handler\ErasmusHandler;
use ESN\MembersBundle\Form\Handler\MembersHandler;
use ESN\MembersBundle\Form\MembersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ESN\MembersBundle\Entity\Member;
use ESN\MembersBundle\Entity\Erasmus;
use Symfony\Component\HttpFoundation\Request;

class MembersController extends Controller
{   
    /**
     * Action à l'affichage de la page index.html.twig
     * Affiche sur la page : 
     *  - titre de la page
     *  - action : lister,detailler,editer
     *  - id : id du membre s'il s'agit d'une action detailler ou editer
     * @param type $type
     * @param type $action
     * @param type $id
     * @return type
     */
    public function indexAction($action,$type=null,$id=null)
    {
        $data = array(
            'title' => "Members", 
            'type' => $type, 
            'action' => $action, 
            'id' => $id);
        return $this->render('ESNMembersBundle::index.html.twig', $data);
    }//indexAction
    
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

        //var_dump($member['member'][0]['esner']->getAddress());die();

        if ($type == 'esners') {
            return $this->render('ESNMembersBundle:Esners:detail.html.twig', $member);
        } else {
            return $this->render('ESNMembersBundle:Erasmus:detail.html.twig', $member);
        }
    }//detailAction
    
    /**
     * Action à l'affichage de la page d'édition d'un membre en fonction
     * du type du membre et de son ID.
     * @param type $type
     * @param type $id
     * @return type
     */
    public function editAction(Request $request, $type, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $universities = $em->getRepository('ESNAdministrationBundle:University')->findAll();
        $languages = $em->getRepository('ESNAdministrationBundle:Country')->findAll();

        $data = array(
            'member' => $this->getAllMembers($type, $id),
            'universities' => $universities,
            'languages' => $languages,
        );


        $form = $this->createFormBuilder()
            ->add('email', null)
            ->add('phone', null)
            ->add('name', null)
            ->add('surname', null)
            ->add('birthday', null)
            ->add('nationality', null)
            ->add('address', null)
            ->add('city', null)
            ->add('zipcode', null)
            ->add('study', null)
            ->add('university', null)
            ->add('language', null)
            ->add('language', null)
            ->add('language', null)
            ->getForm();

        $form->handleRequest($request);

        $template = ($type == 'esners') ? 'Esners' : 'Erasmus';

        return $this->render("ESNMembersBundle:$template:form.html.twig", array(
                "data" => $data,
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
    private function getAllMembers($type,$id=null) {
        $repositoryEsner = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Esner');
        $repositoryErasmus = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Erasmus');
        $repositoryMember = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Member');
        
        $list_member = array();
        if (!$id) {
            // Retourne un array avec 'esner':Object Esner, 'identity':Object Member
            if ($type == "esners") {
                $list_esner = $repositoryEsner->findAll();
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
                $esner_identity = $repositoryMember->find($esner->getMember()->getId());
                array_push($list_member,array('esner'=>$esner,'identity'=>$esner_identity));
            } else {
                $erasmus = $repositoryErasmus->find($id);
                $erasmus_identity = $repositoryMember->find($erasmus->getMember()->getId());
                array_push($list_member,array('erasmus'=>$erasmus,'identity'=>$erasmus_identity));  
            }
        }
        return $list_member;
    }//getElementMember
    
    public function createErasmusAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $form = $this->get('form.factory')->create(new ErasmusType());
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
