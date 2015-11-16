<?php

namespace ESN\TreasuryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\TreasuryBundle\Entity\Operation;
use ESN\TreasuryBundle\Entity\Caisse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\NoResultException;

class TreasuryController extends Controller
{
    public function indexAction()
    {
        $data = array('title' => "Treasury", 'type' => $type);
        return $this->render('ESNTreasuryBundle::index.html.twig', $data);
    }
    
    /**
     * Liste les operations
     * @param Request $request
     * @return type
     */
    public function listAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT c
            FROM ESNTreasuryBundle:Caisse c
            ORDER BY c.date DESC
            '
        )->setMaxResults(1);
        
        try {
            $montantQuery = $query->getSingleResult();
            $montant = $montantQuery->getMontant();
        } catch (NoResultException $e) {
            $montant = 0;
        }
        
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNTreasuryBundle:Operation');
        
        $operations = array("operations" => $repository->findAll(), "caisse" => $montant);
                
        return $this->render('ESNTreasuryBundle:Operations:list.html.twig',$operations);
        
    }
    /**
     * Voir le detail de la tresorie
     * @param type $id
     * @return type
     * @throws type
     */
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
    /**
     * Ajouter une operation
     * @param Request $request
     * @return type
     */
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
            $this->get('activity.manager')->create($operation);

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
            
            try {
                $montantQuery = $query->getSingleResult();
                $montant = $montantQuery->getMontant();
            } catch (NoResultException $e) {
                $montant = 0;
            }

            $em = $this->getDoctrine()->getManager();
            
            $caisse = new Caisse();
            $caisse->setMontant($montant+$operation->getMontant());
            
            $em->persist($caisse);
            $em->flush();

            $this->get('activity.manager')->create($caisse);

            $request->getSession()->getFlashBag()->add('notice', 'Opération bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_treasury_list'));
        }
        return $this->render('ESNTreasuryBundle:Operations:add.html.twig', array(
             'title' => "Treasury",
            'form' => $form->createView(),
        ));
    }
    
    
}
