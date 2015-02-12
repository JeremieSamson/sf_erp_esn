<?php

namespace ESN\TreasuryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TreasuryController extends Controller
{
     public function indexAction($type)
    {
        $data = array('title' => "Treasury", 'type' => $type);
        return $this->render('ESNTreasuryBundle::index.html.twig', $data);
    }
    public function seeAction()
    {
        return $this->render('ESNTreasuryBundle:Operations:see.html.twig', array(
            'title' => "Treasury"
        ));
    }
    public function addAction()
    {
        return $this->render('ESNTreasuryBundle:Operations:add.html.twig', array(
            'title' => "Treasury"
        ));
    }
    public function listAction()
    {
        return $this->render('ESNTreasuryBundle:Operations:list.html.twig', array(
            'title' => "Treasury"
        ));
    }
    
}
