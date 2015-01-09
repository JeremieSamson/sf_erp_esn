<?php

namespace ESN\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNUserBundle::index.html.twig', array(
            'title' => "Users"
        ));
    }
}
