<?php

namespace ESN\TreasuryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\TreasuryBundle\Entity\Operation;
use ESN\TreasuryBundle\Entity\Caisse;
use Symfony\Component\HttpFoundation\Request;

class TreasuryController extends Controller
{
    public function indexAction()
    {
        $data = array('title' => "Treasury", 'type' => $type);
        return $this->render('ESNTreasuryBundle::index.html.twig', $data);
    }
    public function listAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT c
            FROM ESNTreasuryBundle:Caisse c
            ORDER BY c.date DESC
            '
        )->setMaxResults(1);
        
        $montant = $query->getSingleResult();
        
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNTreasuryBundle:Operation');
        
        $operations = array("operations" => $repository->findAll(), "caisse" => $montant);
                
        return $this->render('ESNTreasuryBundle:Operations:list.html.twig',$operations);
        
    }
    public function seeAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $operation = $em->getRepository('ESNTreasuryBundle:Operation')->find($id);
        if (!$operation) {
            throw $this->createNotFoundException(
                'Aucune opération trouvée pour cet id : '.$id
            );
        }    
                
         return $this->render('ESNTreasuryBundle:Operations:see.html.twig', array(
             'title' => "Treasury",'operation' => $operation));
        
        
    }
    public function addAction(Request $request)
    {   
        
        // crée une tâche et lui donne quelques données par défaut pour cet exemple
        $operation = new Operation();
        $form = $this->createFormBuilder($operation)
        ->add('libelle', 'text')
        ->add('description', 'textarea')
        ->add('montant', 'money')
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($operation);
            $em->flush();

            // On récupère le montant de la caisse
            $query = $em->createQuery(
            'SELECT c
            FROM ESNTreasuryBundle:Caisse c
            ORDER BY c.date DESC
            '
            )->setMaxResults(1);
        
            $montant = $query->getSingleResult();
            
            $em = $this->getDoctrine()->getManager();
            
            $caisse = new Caisse();
            $caisse->setMontant($montant->getMontant()+$operation->getMontant());
            
            $em->persist($caisse);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Opération bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_treasury_list'));
        }
        return $this->render('ESNTreasuryBundle:Operations:add.html.twig', array(
             'title' => "Treasury",
            'form' => $form->createView(),
        ));
    }
    
    
}
