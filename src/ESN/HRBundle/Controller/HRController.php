<?php

namespace ESN\HRBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HRController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNHRBundle::index.html.twig', array(
            'title' => "Human Resources"
        ));
    }
}
