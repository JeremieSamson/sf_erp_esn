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
}
