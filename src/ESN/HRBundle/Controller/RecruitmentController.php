<?php

namespace ESN\HRBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecruitmentController extends Controller {

    public function indexAction()
    {
        $data = array('title' => "HR", 'type' => 'recruitment');
        return $this->render('ESNHRBundle::index.html.twig', $data); 
    } 
    
    public function listApplyAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNHRBundle:Apply');
        $applies = array( "applies" => $repository->findAll() );
                
        return $this->render('ESNHRBundle:Recruitment:list.html.twig', $applies);
        
    }
    
    public function viewApplyAction($id) {
        
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNHRBundle:Apply');
        $apply = array( "apply" => $repository->find($id));
        
        return $this->render('ESNHRBundle:Recruitment:detail.html.twig', $apply);
        
    }
    
    public function deleteApplyAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $apply = $em->getRepository('ESNHRBundle:Apply')->find($id);
                
        if (!$apply) {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }       
        
        $em->remove($apply);
        $em->flush();

        return $this->redirect($this->generateUrl('esn_hr_recruitment'));
        
    }
}
