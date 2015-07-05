<?php

namespace ESN\HRBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HRController extends Controller
{
    public function indexAction($type, $action)
    {
        $data = array('title' => "Human Resources", 'type' => $type, 'action' => $action);
        return $this->render('ESNHRBundle::index.html.twig', $data);
    }
    
    /**
     * Affiche la liste ou le formulaire selon la valeur de action
     * @param type $action
     * @return type
     */
    public function associationAction($action)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Member');
        $members = array( "members" => $repository->findAll() );

        switch($action) {
            case "list" :
                return $this->render('ESNHRBundle:Association:list.html.twig', $members);
                break;
            
            case "add" : 
                return $this->render('ESNHRBundle:Association:form.html.twig');
                break;
        } 
    }
    
    /**
     * Affiche le detail des recrutement en cours
     * @return type
     */
    public function recruitmentAction()
    {
        return $this->render('ESNHRBundle:Recruitment:detail.html.twig');
    }

    public function treeceratopsAction()
    {
        $esners = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Esner')->findAll();
        return $this->render('ESNHRBundle:Recruitment:treeceratops.html.twig', array("esners" => $esners));
    }
}
