<?php

namespace ESN\PermanenceBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use ESN\PermanenceBundle\Form\EnrollUserToTripType;
use ESN\PermanenceBundle\Form\Handler\EnrollUserToTripHandler;

use ESN\PermanenceBundle\Form\Handler\ReportHandler;
use ESN\PermanenceBundle\Form\Type\ReportType;
use ESN\TreasuryBundle\Entity\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ESN\PermanenceBundle\Entity\ParticipateTrip;
use ESN\PermanenceBundle\Entity\PermanenceReport;
use ESN\AdministrationBundle\Entity\Card;
use ESN\AdministrationBundle\Entity\CardRepository;
use ESN\TreasuryBundle\Entity\Caisse;
use ESN\TreasuryBundle\Entity\CaisseRepository;

class PermanenceController extends Controller
{
    /**
     * List all reports
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $reports = $em->getRepository('ESNPermanenceBundle:PermanenceReport')->findBy(array(), array('date' => 'DESC'));

        return $this->render('ESNPermanenceBundle:Reports:list.html.twig', array(
            'reports' => $reports
        ));
    }
    
    /**
     * Retourne le montant de la caisse et le nombre de carte disponible.
     * @return type
     */
    public function informationsAction()
    { 
        $em = $this->getDoctrine()->getManager();
       
        // CAISSE
        $montant = $em->getRepository('ESNTreasuryBundle:Caisse')->getLastCaisse();

        // CARD
        $nbCard = $em->getRepository('ESNAdministrationBundle:Card')->getNumberOfCards();
        
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
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $participateTrip = new ParticipateTrip();

        $form = $this->get('form.factory')->create(new EnrollUserToTripType(), $participateTrip);
        $formHandler = new EnrollUserToTripHandler($em, $form, $request);
        $form->handleRequest($request);

        if ($formHandler->process()){
            $this->get('activity.manager')->create($participateTrip);

            $participateTrips = $em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findByTrip($participateTrip->getTrip());

            $users = new ArrayCollection();
            /** @var ParticipateTrip $participateTrip */
            foreach($participateTrips as $participateTrip){
                if (!$users->contains($participateTrip->getUser()))
                    $users->add($participateTrip->getUser());
            }

            $request->getSession()->getFlashBag()->add('notice', 'participant bien enregistré.');

            return $this->render('ESNPermanenceBundle:Trips:detailsTrip.html.twig',
                array('participants' => $users,
                      'trip' => $participateTrip->getTrip()));
        }

        return $this->render('ESNPermanenceBundle:Trips:enrollUserToTrip.html.twig',
            array('form' => $form->createView(),
                  'title' => "Permanence")
        );
    }
    
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

        return $this->render('ESNPermanenceBundle:Trips:detailsTrip.html.twig',
            array('participants' => $participants,
                  'title' => "Permanence",
                  'trip' => $trip));
    }//detailTripsAction
    
    /**
     * Retourne la liste des rapports et les donne à la vue
     * @return type
     */
    public function reportsListAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNPermanenceBundle:PermanenceReport');
        
        $reports = array("reports" => $repository->findAll());

        return $this->render('ESNPermanenceBundle:Reports:listReports.html.twig',$reports);
    }//reportsListAction
    
    /**
     * Crée le formulaire de rapport et sauvegarde un nouveau rapport en base.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function createAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var integer $caisse */
        $caisse = $em->getRepository('ESNTreasuryBundle:Caisse')->getLastCaisse();

        /** @var integer $nbCard */
        $nbCard = $em->getRepository('ESNAdministrationBundle:Card')->getNumberOfCards();

        $report = new PermanenceReport();
        $report->setAmountBefore($caisse);
        $report->setAmountAfter($caisse);
        $report->setAvailableCard($nbCard);

        $form = $this->get('form.factory')->create(new ReportType($em), $report);
        $formHandler = new ReportHandler($em, $form, $request);
        $form->handleRequest($request);

        if ($formHandler->process())
        {
            $this->get('activity.manager')->create($report);

            $request->getSession()->getFlashBag()->add('notice', 'Rapport bien enregistrée.');

            return $this->redirect($this->generateUrl('esn_permanence_reports'));
        }
        
        return $this->render('ESNPermanenceBundle:Reports:create.html.twig', array(
            'form'  => $form->createView(),
            'cards' => $nbCard,
            'money' => $caisse
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
