<?php

namespace ESN\PermanenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ESN\PermanenceBundle\Entity\ParticipateTrip;
use ESN\PermanenceBundle\Entity\PermanenceReport;

class PermanenceController extends Controller
{
    public function indexAction($type)
    {
        $data = array('title' => "Permanence", 'type' => $type);
        return $this->render('ESNPermanenceBundle::index.html.twig', $data);
    }
    
    /**
     * Retourne le montant de la caisse et le nombre de carte disponible.
     * @return type
     */
    public function informationsAction()
    { 
        $em = $this->getDoctrine()->getManager();
       
        // CAISSE
        $query = $em->createQuery(
            'SELECT c
            FROM ESNTreasuryBundle:Caisse c
            ORDER BY c.date DESC
            '
        )->setMaxResults(1);
        
        $montantQuery = $query->getOneOrNullresult();
        
        if ($montantQuery == NULL) {
            $montant = 0;
        } else {
            $montant = $montantQuery->getMontant();
        }
        
        // CARD
        $queryCard = $em->createQuery(
            'SELECT c
            FROM ESNAdministrationBundle:Card c
            ORDER BY c.date DESC
            '
        )->setMaxResults(1);
        
        
        $nbCardQuery = $queryCard->getOneOrNullresult();
        if ($nbCardQuery == NULL) {
            $nbCard = 0;
        } else {
            $nbCard = $nbCardQuery->getNumber();
        }
        
        // RENDER RESULT
        $informations= array("caisse" => $montant,"nbCard" => $nbCard);
        
        return $this->render('ESNPermanenceBundle:Informations:index.html.twig',$informations);
    }
    
    /**
     * Retourne la liste des voyages
     * @return type
     */
    public function tripsListAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Trip');
       
        $trips = array("trips" => $repository->findAll());
        
        return $this->render('ESNPermanenceBundle:Trips:listTrips.html.twig',$trips);
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function enrollUserToTripAction(Request $request)
    {
        $participateTrip = new ParticipateTrip();
        
        // CREATE FORM
        $form = $this->createFormBuilder($participateTrip)
        ->add('trips', 'entity', array(
            'class' => 'ESNAdministrationBundle:Trip', 
            'property' => 'name'))
        ->add('members', 'entity', array(
            'class' => 'ESNMembersBundle:Member',
            'property' => 'name'))
        ->getForm();
        
        $form->handleRequest($request);
        
        // FORM VALID
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($participateTrip);
            $em->flush();
        }
        
        return $this->render('ESNPermanenceBundle:Trips:enrollUserToTrip.html.twig',array('form' => $form->createView(),'title' => "Permanence")); 
    }//enrollUserToTripAction
    
    /**
     * Récupère un voyage en fonction de son ID
     * @param type $id
     * @return type
     * @throws NotFoundHttpException
     */
    public function detailTripsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $trip = $em->getRepository('ESNAdministrationBundle:Trip')->find($id);
        
        if (null === $trip) {
            throw new NotFoundHttpException("Le voyage d'id ".$id." n'existe pas.");
        }
        
        $participants = $em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findByTrip($trip);
        
        $members = array();
        
        foreach ($participants as $participant) {
                    $member = $em->getRepository('ESNMembersBundle:Member')->find($participant->getMembers());
                    array_push($members,$member);
        }
                
        return $this->render('ESNPermanenceBundle:Trips:detailsTrip.html.twig', array('erasmus' => $members,
             'title' => "Permanence",'trip' => $trip)); 
    }//detailTripsAction
    
    /**
     * Retourne la liste des rapports et les donne à la vue
     * @return type
     */
    public function reportsListAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNPermanenceBundle:PermanenceReport');
        
        $operations = array("reports" => $repository->findAll());
                
        return $this->render('ESNPermanenceBundle:Reports:listReports.html.twig',$operations);
    }//reportsListAction
    
    /**
     * Crée le formulaire de rapport et sauvegarde un nouveau rapport en base.
     * @param type $type
     * @param Request $request
     * @return type
     */
    public function createReportAction($type,Request $request)
    {
        $report = new PermanenceReport();
         
        $form = $this->createFormBuilder($report)
        ->add('amountBefore', 'money')
        ->add('amountAfter', 'money')
        ->add('amountSell', 'money')
        ->add('sellCard', 'integer')
        ->add('availableCard', 'integer')
        ->add('comments', 'textarea')
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($report);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Rapport bien enregistrée.');
        }
        
        return $this->render('ESNPermanenceBundle:Reports:createReport.html.twig', array(
            'title' => "Treasury",
            'type' => $type,
            'form' => $form->createView(),
        ));
    }//createReportAction
    
    /**
     * récupère un rapport par son ID et le donne à la vue.
     * @param type $type
     * @param Request $request
     * @param type $id
     * @return type
     * @throws type
     */
    public function seeReportAction($type,Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $report = $em->getRepository('ESNPermanenceBundle:PermanenceReport')->find($id);
        if (!$report) {
            throw $this->createNotFoundException(
                'Aucun rapport trouvé pour cet id : '.$id
            );
        }    
                
        return $this->render('ESNPermanenceBundle:Reports:seeReport.html.twig', array(
             'title' => "Permanence",'report' => $report));
    }//seeReportAction
}
