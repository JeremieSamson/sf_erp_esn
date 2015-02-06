<?php

namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\University;
use Symfony\Component\HttpFoundation\Request;

class UniversitiesController extends Controller
{    

     public function indexAction()
    {
        $data = array('title' => "Administration", 'type' => 'universities');
        return $this->render('ESNAdministrationBundle::index.html.twig', $data);
        
    }
    
    public function listUniversitiesAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:University');
                $universities = array(
                    "universities" => $repository->findAll()
                        );
                
        return $this->render('ESNAdministrationBundle:Universities:list.html.twig', $universities);
        
    }
    
     public function newUniversityAction(Request $request)
    {
       
// crée une tâche et lui donne quelques données par défaut pour cet exemple
        $university = new University();
        $form = $this->createFormBuilder($university)
        ->add('name', 'text')
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($university);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_universities'));
        }
        return $this->render('ESNAdministrationBundle:Universities:form.html.twig', array(
            'type' => "universities",
            'form' => $form->createView(),
        ));
    }
    
    function deleteUniversityAction($id) {
        $em = $this->getDoctrine()->getManager();
        $university = $em->getRepository('ESNAdministrationBundle:University')->find($id);
        if (!$university) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        $em->remove($university);
        $em->flush();

        return $this->redirect($this->generateUrl('esn_administration_universities'));
        
    }
    
    function editUniversityAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $university = $em->getRepository('ESNAdministrationBundle:University')->find($id);
        if (!$university) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        
        $form = $this->createFormBuilder($university)
        ->add('name', 'text')
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_universities'));
        }
        return $this->render('ESNAdministrationBundle:Universities:form.html.twig', array(
            'type' => "universities",
            'form' => $form->createView(),
        ));
    }
}
