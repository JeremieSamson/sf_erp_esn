<?php


namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\Rule;
use Symfony\Component\HttpFoundation\Request;

class RulesController extends Controller{
    
    public function indexAction()
    {
        $data = array('title' => "Administration", 'type' => 'rules');
        return $this->render('ESNAdministrationBundle::index.html.twig', $data);
        
    }
    
    public function listRulesAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Rule');
                $rules = array(
                    "rules" => $repository->findAll()
                        );
                
        return $this->render('ESNAdministrationBundle:Rules:list.html.twig', $rules);
        
    }
    
     public function newRuleAction(Request $request)
    {
       
// crée une tâche et lui donne quelques données par défaut pour cet exemple
        $rule = new Rule();
        $form = $this->createFormBuilder($rule)
        ->add('name', 'text')
        ->add('description', 'textarea')       
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_rules'));
        }
        return $this->render('ESNAdministrationBundle:Rules:form.html.twig', array(
            'type' => "rules",
            'form' => $form->createView(),
        ));
    }
    
    function deleteRuleAction($id) {
        $em = $this->getDoctrine()->getManager();
        $rule = $em->getRepository('ESNAdministrationBundle:Rule')->find($id);
        if (!$rule) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        $em->remove($rule);
        $em->flush();

        return $this->redirect($this->generateUrl('esn_administration_rules'));
        
    }
    
    function editRuleAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $rule = $em->getRepository('ESNAdministrationBundle:Rule')->find($id);
        if (!$rule) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        
        $form = $this->createFormBuilder($rule)
        ->add('name', 'text')
        ->add('description', 'textarea')       
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_rules'));
        }
        return $this->render('ESNAdministrationBundle:Rules:form.html.twig', array(
            'type' => "rules",
            'form' => $form->createView(),
        ));
    }
   
}
