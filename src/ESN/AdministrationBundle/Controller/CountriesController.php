<?php


namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\Country;
use Symfony\Component\HttpFoundation\Request;

class CountriesController extends Controller{
    
    public function indexAction()
    {
        $data = array('title' => "Administration", 'type' => 'countries');
        return $this->render('ESNAdministrationBundle::index.html.twig', $data);
        
    }
    
    public function listCountriesAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Country');
                $countries = array(
                    "countries" => $repository->findAll()
                        );
                
        return $this->render('ESNAdministrationBundle:Countries:list.html.twig', $countries);
        
    }
    
     public function newCountryAction(Request $request)
    {
       
// crée une tâche et lui donne quelques données par défaut pour cet exemple
        $country = new Country();
        $form = $this->createFormBuilder($country)
        ->add('name', 'text')
        ->add('nationality', 'text')
        ->add('language', 'text')
        ->add('Save', 'submit')      
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_countries'));
        }
        return $this->render('ESNAdministrationBundle:Countries:form.html.twig', array(
            'type' => "countries",
            'form' => $form->createView(),
        ));
    }
    
    function deleteCountryAction($id) {
        $em = $this->getDoctrine()->getManager();
        $country = $em->getRepository('ESNAdministrationBundle:Country')->find($id);
        if (!$country) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        $em->remove($country);
        $em->flush();

        return $this->redirect($this->generateUrl('esn_administration_countries'));
        
    }
    
    function editCountryAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $country = $em->getRepository('ESNAdministrationBundle:Country')->find($id);
        if (!$country) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        
        $form = $this->createFormBuilder($country)
        ->add('name', 'text')
        ->add('nationality', 'text')
        ->add('language', 'text')
        ->add('Save', 'submit')
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_countries'));
        }
        return $this->render('ESNAdministrationBundle:Countries:form.html.twig', array(
            'type' => "countries",
            'form' => $form->createView(),
        ));
    }
   
}
