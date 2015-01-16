<?php

namespace ESN\HRBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HRController extends Controller
{
    public function indexAction($type)
    {
        $data = array('title' => "Human Resources", 'type' => $type);
        return $this->render('ESNHRBundle::index.html.twig', $data);
    }
    
    public function associationAction()
    {
        return $this->render('ESNHRBundle:HR:association.html.twig');  
    }
    
    public function recruitmentAction()
    {
        return $this->render('ESNHRBundle:HR:recruitment.html.twig');
    }
}
