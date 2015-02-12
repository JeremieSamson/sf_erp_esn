<?php

namespace ESN\PermanenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PermanenceController extends Controller
{
    public function indexAction($type)
    {
        $data = array('title' => "Permanence", 'type' => $type);
        return $this->render('ESNPermanenceBundle::index.html.twig', $data);
    }
    
    public function informationsAction()
    { 
        return $this->render('ESNPermanenceBundle:Informations:index.html.twig');
    }
    
    public function tripsListAction()
    {
            return $this->render('ESNPermanenceBundle:Trips:listTrips.html.twig');
    }
    
    public function reportsListAction()
    {
        return $this->render('ESNPermanenceBundle:Reports:listReports.html.twig');
    }
}
