<?php

namespace ESN\HRBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HRController extends Controller
{
    /**
     * @param $type
     * @param $action
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($type, $action)
    {
        return $this->render('ESNHRBundle::index.html.twig',  array(
            'title' => "Human Resources",
            'type' => $type,
            'action' => $action
        ));
    }
    
    /**
     * Affiche la liste ou le formulaire selon la valeur de action
     * @param string $action
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

    /**
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function treeceratopsAction()
    {
        $esners = $this->getDoctrine()->getManager()->getRepository('ESNUserBundle:User')->findBy(array("esner" => 1));

        return $this->render('ESNHRBundle:Recruitment:treeceratops.html.twig', array(
            "esners" => $esners
        ));
    }
}
