<?php

namespace ESN\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * Affiche la page dashboard
     * @return type
     */
    public function indexAction()
    {    
        return $this->render('ESNDashboardBundle::index.html.twig', array(
            'title' => "Dashboard"
        ));
    }
    
    /**
     * Affiche le subnavbar
     * @return type
     */
    public function subnavbarAction()
    {
        return $this->render('ESNDashboardBundle:Dashboard:subnavbar.html.twig');
    }
    
    /**
     * 
     * @return type
     */
    public function dashboardAction() {
        
        return $this->render('ESNDashboardBundle:Dashboard:dashboard.html.twig');
    }
}
