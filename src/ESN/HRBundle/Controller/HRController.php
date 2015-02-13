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
    
    public function recruitmentAction()
    {
        return $this->render('ESNHRBundle:Recruitment:detail.html.twig');
    }
}
