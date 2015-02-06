<?php

namespace ESN\TreasuryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TreasuryController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNTreasuryBundle::index.html.twig', array(
            'title' => "Treasury"
        ));
    }
}
