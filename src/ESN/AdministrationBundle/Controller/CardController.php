<?php


namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\Card;
use Symfony\Component\HttpFoundation\Request;

class CardController extends Controller{
    
    
     public function addCardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
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
            $nbCard = $nbCardQuery.getNumber();
        }

        // CREATE CARD
        $rule = new Card();

        $form = $this->createFormBuilder($rule)
        ->add('number', 'integer')    
        ->getForm();

        $form->handleRequest($request);

        // TEST FORM VALID
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Carte bien enregistrée.');

            return $this->redirect($this->generateUrl('esn_administration_cards'));
        }

        // RENDER RESULT
        return $this->render('ESNAdministrationBundle:Cards:form.html.twig', array(
            'type' => "card",
            'form' => $form->createView(),
            'nbCard' => $nbCard,
        ));
    }
}
