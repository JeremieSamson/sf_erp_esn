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
            'liste_membres' =>$type == 'esners' ? $this->esners : $this->erasmus
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
        $table = $type == 'esners' ? $this->esners : $this->erasmus;
        foreach ($table as $m) {
            if ($m['id'] == $id) {
                $personne = $m;
            }
        }
        if ($type == 'esners') {
            return $this->render('ESNMembersBundle:Esners:detail.html.twig', $personne);
        } else {
            return $this->render('ESNMembersBundle:Erasmus:detail.html.twig', $personne);
        } 
    }

    public function editAction($type, $id)
    {
         $table = $type == 'esners' ? $this->esners : $this->erasmus;
        foreach ($table as $m) {
            if ($m['id'] == $id) {
                $personne = $m;
            }
        }
        return $this->render('ESNMembersBundle:Erasmus:form.html.twig', $personne);
    }
}
