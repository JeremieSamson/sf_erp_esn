<?php

namespace ESN\HRBundle\Controller;

use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Entity\Apply;
use ESN\HRBundle\Form\Handler\ApplyHandler;
use ESN\HRBundle\Form\Type\ApplyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecruitmentController extends Controller {

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $data = array('title' => "HR", 'type' => 'recruitment');
        return $this->render('ESNHRBundle::index.html.twig', $data); 
    } 
    
    /**
     * Lister les applies
     * @param Request $request
     * @return type
     */
    public function listApplyAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNHRBundle:Apply');
        $applies = array( "applies" => $repository->findAll() );
                
        return $this->render('ESNHRBundle:Recruitment:list.html.twig', $applies);
        
    }
    
    /**
     * Voir les applies
     * @param type $id
     * @return type
     */
    public function viewApplyAction($id) {
        
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNHRBundle:Apply');
        $apply = array( "apply" => $repository->find($id));
        
        return $this->render('ESNHRBundle:Recruitment:detail.html.twig', $apply);
        
    }
    
    /**
     * Supprimer un apply dont l'id est passé en parametre
     * @param type $id
     * @return type
     * @throws type
     */
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

    /**
     * Create Apply Action
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createApplyAction(Request $request) {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Apply $apply */
        $apply = new Apply();

        $form = $this->get('form.factory')->create(new ApplyType($em), $apply);
        $formHandler = new ApplyHandler($em, $form, $request, $this->container, $this->get('templating'), $this->get('mailer'));
        $form->handleRequest($request);

        if ($formHandler->process())
        {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Votre candidature a bien été prise en compte, vous serez bientôt contacté par notre Vice-Président pour faire suite à votre candidature'
            );

            return $this->redirect($this->generateUrl('esn_hr_recruitment_create'));
        }

        return $this->render('ESNHRBundle:Recruitment:form.html.twig',
            array(
                'form' => $form->createView(),
                'hasError' => $request->getMethod() == 'POST' && !$form->isValid()
            )
        );
    }
}
