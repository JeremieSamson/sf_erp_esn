<?php

namespace ESN\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        
        return $this->render('ESNDashboardBundle::index.html.twig', array(
            'title' => "Dashboard"
        ));
  
    }
    
    public function subnavbarAction()
    {
        return $this->render('ESNDashboardBundle:Dashboard:subnavbar.html.twig');
    }
    
    public function dashboardAction() {
        
        return $this->render('ESNDashboardBundle:Dashboard:dashboard.html.twig');
    }
}
