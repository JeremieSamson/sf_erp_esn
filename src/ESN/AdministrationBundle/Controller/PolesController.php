<?php


namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\Pole;
use Symfony\Component\HttpFoundation\Request;

class PolesController extends Controller{
    
    public function indexAction()
    {
        $data = array('title' => "Administration", 'type' => 'poles');
        return $this->render('ESNAdministrationBundle::index.html.twig', $data);
        
    }
    
    /**
     * Lister les poles de la base de données
     * @param Request $request
     * @return type
     */
    public function listPolesAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Pole');
                $poles = array(
                    "poles" => $repository->findAll()
                        );
                
        return $this->render('ESNAdministrationBundle:Poles:list.html.twig', $poles);
        
    }
    
    /**
     * Creer un nouveau pole
     * @param Request $request
     * @return type
     */
    public function newPoleAction(Request $request)
    {
       
// crée une tâche et lui donne quelques données par défaut pour cet exemple
        $pole = new Pole();
        $pole->setNbMembers(0);
        $form = $this->createFormBuilder($pole)
        ->add('name', 'text')
        ->add('description', 'textarea')       
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($pole);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_poles'));
        }
        return $this->render('ESNAdministrationBundle:Poles:form.html.twig', array(
            'type' => "poles",
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Supprimer le pole passe en parametre
     * @param type $id
     * @return type
     * @throws type
     */
    function deletePoleAction($id) {
        $em = $this->getDoctrine()->getManager();
        $pole = $em->getRepository('ESNAdministrationBundle:Pole')->find($id);
        if (!$pole) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        $em->remove($pole);
        $em->flush();

        return $this->redirect($this->generateUrl('esn_administration_poles'));
        
    }
    
    /**
     * Editer le pole passe en parametre
     * @param Request $request
     * @param type $id
     * @return type
     * @throws type
     */
    function editPoleAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $pole = $em->getRepository('ESNAdministrationBundle:Pole')->find($id);
        if (!$pole) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }        
        
        $form = $this->createFormBuilder($pole)
        ->add('name', 'text')
        ->add('description', 'textarea')       
        ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            return $this->redirect($this->generateUrl('esn_administration_poles'));
        }
        return $this->render('ESNAdministrationBundle:Poles:form.html.twig', array(
            'type' => "poles",
            'form' => $form->createView(),
        ));
    }
   
}
