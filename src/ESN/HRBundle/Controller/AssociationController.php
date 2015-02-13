<?php

namespace ESN\HRBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\MembersBundle\Entity\Member;
use ESN\MembersBundle\Entity\Esner;
use ESN\HRBundle\Entity\InfoEsner;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

class AssociationController extends Controller{
       
    public function indexAction()
    {
        $data = array('title' => "HR", 'type' => 'association');
        return $this->render('ESNHRBundle::index.html.twig', $data); 
    } 
    
    public function listEsnersAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Esner');
        $esners = array( "esners" => $repository->findAll() );
                
        return $this->render('ESNHRBundle:Association:list.html.twig', $esners);
        
    }
    
    public function newEsnerAction(Request $request)
    {
        $member = new Member();
        $esner = new Esner();
        $infoEsner = new InfoEsner();
        
        $form = $this->createFormBuilder($member)
            ->add('name', 'text')
            ->add('surname', 'text')
            ->add('email', 'text')
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            
            $member->setInscription(new DateTime());
            
            $em->persist($member);
    
            $esner->setMember($member);
            $infoEsner->setEsner($esner);
            
            $em->persist($esner);
            $em->persist($infoEsner);
            
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_hr_association'));
        }
        
        return $this->render('ESNHRBundle:Association:form.html.twig', array(
            'type' => "association",
            'form' => $form->createView(),
        ));   
    }
    
    public function deleteEsnerAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $member = $em->getRepository('ESNMembersBundle:Member')->find($id);
        $esner = $em->getRepository('ESNMembersBundle:Esner')->findOneByMember($member);
        $infoEsner = $em->getRepository('ESNHRBundle:InfoEsner')->findOneByEsner($esner);
        
        if (!$esner) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }       
        
        $em->remove($infoEsner);
        $em->remove($esner);
        $em->remove($member);
        $em->flush();

        return $this->redirect($this->generateUrl('esn_hr_association'));
        
    }
    
    function editEsnerAction(Request $request, $id) {
        
        $em = $this->getDoctrine()->getManager();
        
        $member = $em->getRepository('ESNMembersBundle:Member')->find($id);
        $esner = $em->getRepository('ESNMembersBundle:Esner')->findOneByMember($member);
        $infoEsner = $em->getRepository('ESNHRBundle:InfoEsner')->findOneByEsner($esner);

        if (!$member) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        
        $form = $this->createFormBuilder($infoEsner)
        ->add('cotisation', 'date')
        ->add('comment', 'textarea')
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_hr_association'));
        }
        return $this->render('ESNHRBundle:Association:edit.html.twig', array(
            'infoEsner' => $infoEsner,
            'type' => "association",
            'form' => $form->createView(),
        ));
    }
}