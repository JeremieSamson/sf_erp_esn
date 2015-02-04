<?php

namespace ESN\AdministrationBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\Country;
use Symfony\Component\HttpFoundation\Request;


class AdministrationAddController extends Controller{
    
    public function newCountryAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Country');
                $countries = array(
                    "countries" => $repository->findAll()
                        );

// crée une tâche et lui donne quelques données par défaut pour cet exemple
        $country = new Country();
        $form = $this->createFormBuilder($country)
        ->add('name', 'text')
        ->add('nationality', 'text')
        ->add('language', 'text')
        ->add('save', 'submit')
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            return $this->render('ESNAdministrationBundle:Countries:list.html.twig', $countries);
        }
        return $this->render('ESNAdministrationBundle:Countries:form.html.twig', array(
            'form' => $form->createView(),
));
    }
}
