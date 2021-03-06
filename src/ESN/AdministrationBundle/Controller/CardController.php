<?php


namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\Card;
use Symfony\Component\HttpFoundation\Request;

class CardController extends Controller{
    
    /**
     * Affiche le nombre de cartes disponibles et un formulaire pour ajouter de nouvelles cartes
     * @param Request $request
     * @return type
     */
    public function addCardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $nbCard = $em->getRepository('ESNAdministrationBundle:Card')->getNumberOfCards();

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
