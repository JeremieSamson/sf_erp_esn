<?php

namespace ESN\MembersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MembersController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNMembersBundle::index.html.twig', array(
            'title' => "Members"
            ));
    }
    
    public function listAction()
    {
        return $this->render('ESNMembersBundle:Erasmus:list.html.twig');
    }
    
    public function detailAction()
    {
        return $this->render('ESNMembersBundle:Erasmus:detail.html.twig');
    }
    
    public function formAction()
    {
        return $this->render('ESNMembersBundle:Erasmus:form.html.twig');
    }
}
