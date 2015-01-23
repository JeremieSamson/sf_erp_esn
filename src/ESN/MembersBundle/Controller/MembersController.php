<?php

namespace ESN\MembersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MembersController extends Controller
{   
    var $esners = array (
        array('id'=>1,'name' => 'Matthieu','role' => 'Etudiant',
            'mail' => 'matthieu.boeykens@etu.univ-lille1.fr',
            'phone' => '+33 45 45 45 42'
        ),
        array('id'  => 2,'name' => 'Helene','role' => 'BG',
            'mail' => 'helene.lemaire.univ-lille1.fr',
            'phone' => '+33 42 55 66 42'
        )
    );
    
    var $erasmus = array (
        array('id'=>1,'name' => 'Raphael','role' => 'Petit vieux',
            'mail' => 'Raphael.petitVieux@etu.univ-lille1.fr',
            'phone' => '+33 45 45 45 42'
        ),
        array('id'  => 2,'name' => 'Pahoua','role' => 'Tyran démoniaque',
            'mail' => 'pahoua.tyran@666.univ-lille1.fr',
            'phone' => '+33 666'
        )
    );
    
    public function indexAction($type,$id=null,$action)
    {
        $data = array('title' => "Members", 'type' => $type, 'action' => $action, 'id' => $id);
        return $this->render('ESNMembersBundle::index.html.twig', $data);
    }
    
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
    }
    
    public function cardEsnerAction($member) {
        return $this->render('ESNMembersBundle:Esners:card.html.twig', array(
            'member' => $member
             )); 
    }
    
    public function cardErasmusAction($member) {
        return $this->render('ESNMembersBundle:Erasmus:card.html.twig', array(
            'member' => $member
             )); 
    }
    
    public function detailAction($type,$id)
    {
        /* Donnée récupéré sur la bdd*/
        $personne = array(
            'member' => $this->getMember($id, $type)
        );
        
        if ($type == 'esners') {
            return $this->render('ESNMembersBundle:Esners:detail.html.twig', $personne);
        } else {
            return $this->render('ESNMembersBundle:Erasmus:detail.html.twig', $personne);
        } 
    }

    public function editAction($type, $id)
    {
        $personne = array(
            'member' => $this->getMember($id, $type)
        );
        if ($type == 'esners') {
            return $this->render('ESNMembersBundle:Esners:form.html.twig', $personne);
        } else {
            return $this->render('ESNMembersBundle:Erasmus:form.html.twig', $personne);
        }
    }
    
    private function getAllMembers($type) {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Member');
        $list_member;
        if ($type == "esners") {
            $list_member = $repository->findBy(
               array('esner' => 1)    
            );
        } else {
            $list_member = $repository->findBy(
               array('erasmus' => 1)    
            );
        }
        return $list_member;
    }
    
    private function getMember($id,$type) {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Member');
        $member;
        if ($type == "esners") {
            $member = $repository->find($id);
        } else {
            $member = $repository->find($id);
        }
        return $member;
    }
}
