<?php


namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\Card;
use Symfony\Component\HttpFoundation\Request;

class CardController extends Controller{
    
    
     public function addCardAction(Request $request)
    {
       
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT c
            FROM ESNAdministrationBundle:Card c
            ORDER BY c.date DESC
            '
        )->setMaxResults(1);
        
        $nbCard = $query->getSingleResult();
         
         
        // crée une tâche et lui donne quelques données par défaut pour cet exemple
        $rule = new Card();
        
        $form = $this->createFormBuilder($rule)
        ->add('number', 'integer')    
        ->getForm();
        
        $form->handleRequest($request);
        
       
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Carte bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_cards'));
        }
        return $this->render('ESNAdministrationBundle:Cards:form.html.twig', array(
            'type' => "card",
            'form' => $form->createView(),
            'nbCard' => $nbCard,
        ));
    }
}
