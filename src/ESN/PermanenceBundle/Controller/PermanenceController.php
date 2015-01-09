<?php

namespace ESN\PermanenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PermanenceController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNPermanenceBundle::index.html.twig', array(
            'title' => "Permanence"
        ));
    }
}
