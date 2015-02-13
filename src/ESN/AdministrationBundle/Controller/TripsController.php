<?php


namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\Trip;
use Symfony\Component\HttpFoundation\Request;

class TripsController extends Controller{
    
    public function indexAction()
    {
        $data = array('title' => "Administration", 'type' => 'trips');
        return $this->render('ESNAdministrationBundle::index.html.twig', $data);
        
    }
    
    public function listTripsAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Trip');
                $trips = array(
                    "trips" => $repository->findAll()
                        );
                
        return $this->render('ESNAdministrationBundle:Trips:list.html.twig', $trips);
        
    }
    
     public function newTripAction(Request $request)
    {
       
// crée une tâche et lui donne quelques données par défaut pour cet exemple
        $trip = new Trip();
        $form = $this->createFormBuilder($trip)
        ->add('name', 'text')
        ->add('date', 'date')
        ->add('nbPlace', 'integer')
        ->add('description', 'textarea')  
        ->add('price', 'money')       
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($trip);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_trips'));
        }
        return $this->render('ESNAdministrationBundle:Trips:form.html.twig', array(
            'type' => "trips",
            'form' => $form->createView(),
        ));
    }
    
    function deleteTripAction($id) {
        $em = $this->getDoctrine()->getManager();
        $pole = $em->getRepository('ESNAdministrationBundle:Trip')->find($id);
        if (!$pole) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        $em->remove($pole);
        $em->flush();

        return $this->redirect($this->generateUrl('esn_administration_trips'));
        
    }
    
    function editTripAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $trip = $em->getRepository('ESNAdministrationBundle:Trip')->find($id);
        if (!$trip) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        
        $form = $this->createFormBuilder($trip)
        ->add('name', 'text')
        ->add('date', 'date')
        ->add('nbPlace', 'integer')
        ->add('description', 'textarea')    
        ->add('price', 'money')       
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_trips'));
        }
        return $this->render('ESNAdministrationBundle:Trips:form.html.twig', array(
            'type' => "trip",
            'form' => $form->createView(),
        ));
    }
   
}
