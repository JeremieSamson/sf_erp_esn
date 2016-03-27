<?php

namespace ESN\AdministrationBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\University;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{

    /**
     * List all activities
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activitiesAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $activities = $em->getRepository('ESNAdministrationBundle:Activity')->getOrderedActivities("DESC");

        return $this->render('ESNAdministrationBundle:Security:index.html.twig', array(
            "activities" => $activities
        ));
        
    }
}
