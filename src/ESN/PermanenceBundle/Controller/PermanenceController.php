<?php

namespace ESN\PermanenceBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use ESN\AdministrationBundle\Entity\Trip;
use ESN\PermanenceBundle\Form\Handler\EnrollUserToTripHandler;

use ESN\PermanenceBundle\Form\Handler\ReportHandler;
use ESN\PermanenceBundle\Form\Type\EnrollUserToTripType;
use ESN\PermanenceBundle\Form\Type\ReportType;
use ESN\TreasuryBundle\Entity\Operation;
use ESN\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
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
    public function listReportsAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $reports = $em->getRepository('ESNPermanenceBundle:PermanenceReport')->findBy(array(), array('date' => 'DESC'));

        return $this->render('ESNPermanenceBundle:Reports:list.html.twig', array(
            'reports' => $reports
        ));
    }

    /**
     * Delete a report
     *
     * @param integer $report_id
     */
    public function deleteAction($report_id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var PermanenceReport $report */
        $report = $em->getRepository('ESNPermanenceBundle:PermanenceReport')->find($report_id);

        if (!$report) {
            throw $this->createNotFoundException('No report found');
        }

        $em->remove($report);

        $this->get('activity.manager')->delete($report);

        $em->flush();

        $this->get('request')->getSession()->getFlashBag()->add('notice', 'Report deleted');

        return $this->redirect($this->generateUrl('esn_permanence_reports'));
    }
    
    /**
     * Retourne le montant de la caisse et le nombre de carte disponible.
     *
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
     */
    public function listTripsAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var ArrayCollection $trips */
        $trips = $em->getRepository('ESNAdministrationBundle:Trip')->findAll();
        
        return $this->render('ESNPermanenceBundle:Trips:list.html.twig',array(
            "trips" => $trips
        ));
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

            $this->addFlash('notice', 'participant bien enregistré.');

            return $this->render('ESNPermanenceBundle:Trips:detailsTrip.html.twig',
                array('users' => $users,
                      'trip' => $participateTrip->getTrip()
                )
            );
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
            throw $this->createNotFoundException("Le voyage d'id ".$id." n'existe pas.");
        }

        $users = new ArrayCollection();
        $participateTrips = $em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findByTrip($trip);
        /** @var ParticipateTrip $pt */
        foreach($participateTrips as $pt){
            if (!$users->contains($pt->getUser()))
                $users->add($pt->getUser());
        }

        return $this->render('ESNPermanenceBundle:Trips:detailsTrip.html.twig',
            array('users' => $users,
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

        /** @var Form $form */
        $form = $this->get('form.factory')->create(new ReportType($em), $report);
        $formHandler = new ReportHandler($em, $form, $request, $this->getUser());
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
    public function seeReportAction(Request $request,$id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var PermanenceRerport $report */
        $report = $em->getRepository('ESNPermanenceBundle:PermanenceReport')->find($id);

        if (!$report) {
            throw $this->createNotFoundException(
                'Aucun rapport trouvé pour cet id : '.$id
            );
        }    
                
        return $this->render('ESNPermanenceBundle:Reports:detail.html.twig', array(
             'title' => "Permanence",'report' => $report));
    }//seeReportAction

    /**
     * Remove a user from a trip
     *
     * @param $trip_id
     * @param $user_id
     */
    public function removeUserToTripAction($trip_id, $user_id){
        if (!$this->getUser()->hasPermissionFor('human-ressources')){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Trip $trip */
        $trip = $em->getRepository('ESNAdministrationBundle:Trip')->find($trip_id);

        /** @var User $user */
        $user = $em->getRepository('ESNUserBundle:User')->find($user_id);

        if (!$trip || !$user){
            throw $this->createNotFoundException('No trip or User found');
        }

        /** @var ParticipateTrip $participateTrip */
        $participateTrip = $em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findOneBy(array("trip" => $trip, "user" => $user));

        if ($participateTrip){
            $em->remove($participateTrip);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $user->getFullname() . ' bien retiré de ' . $trip->getName());

            $users = new ArrayCollection();
            $participateTrips = $em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findByTrip($trip);
            /** @var ParticipateTrip $pt */
            foreach($participateTrips as $pt){
                if (!$users->contains($pt->getUser()))
                    $users->add($pt->getUser());
            }

            return $this->render('ESNPermanenceBundle:Trips:detailsTrip.html.twig',
                array('users' => $users,
                    'trip' => $trip
                )
            );
        }else{
            throw new \ErrorException('No Participate trip found');
        }
    }
}
