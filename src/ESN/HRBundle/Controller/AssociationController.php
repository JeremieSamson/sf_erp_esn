<?php

namespace ESN\HRBundle\Controller;

use ESN\HRBundle\Form\ESNerType;
use ESN\HRBundle\Form\Handler\ESNerHandler;
use ESN\HRBundle\Form\Handler\InfoESNerHandler;
use ESN\HRBundle\Form\InfoEsnerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\MembersBundle\Entity\Member;
use ESN\MembersBundle\Entity\Esner;
use ESN\HRBundle\Entity\InfoEsner;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
use Symfony\Component\HttpFoundation\Session\Session;

class AssociationController extends Controller{
       
    public function indexAction()
    {
        $data = array('title' => "HR", 'type' => 'association');
        return $this->render('ESNHRBundle::index.html.twig', $data); 
    } 
    
    /**
     * Lister les Esners
     * @param Request $request
     * @return type
     */
    public function listEsnersAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNMembersBundle:Esner');
        $esners = array( "esners" => $repository->findAll() );
                
        return $this->render('ESNHRBundle:Association:list.html.twig', $esners);
        
    }
    
    /**
     * Ajouter un nouvel Esner
     * @param Request $request
     * @return typ
     */
    public function newEsnerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create(new ESNerType($em));
        $formHandler = new ESNerHandler($em, $form, $request);
        $form->handleRequest($request);

        $process = $formHandler->process();
        if ($process) {
            $request->getSession()->getFlashBag()->add('notice', 'Profile added');
            return $this->redirect($this->generateUrl('esn_hr_association'));
        }

        return $this->render('ESNHRBundle:Association:form.html.twig', array(
            'type' => "association",
            'hasError' => $request->getMethod() == 'POST' && !$form->isValid(),
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Supprimer un Esners
     * @param type $id
     * @return type
     * @throws type
     */
    public function deleteEsnerAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $member = $em->getRepository('ESNMembersBundle:Member')->find($id);
        $esner = $em->getRepository('ESNMembersBundle:Esner')->findOneByMember($member);

        if (!$esner) {
            throw $this->createNotFoundException(
                'Aucun esner trouvé pour cet id : '.$id
            );
        }       

        $em->remove($esner);
        $em->remove($member);
        $em->flush();

        // Add Message
        $this->get('request')->getSession()->getFlashBag()->add('notice', 'ESNer deleted');

        // retourne sur la page d'accueil de human resources
        return $this->redirect($this->generateUrl('esn_hr_association'));
        
    }
    
    /**
     * Editer un membre de l'Esn
     * @param Request $request
     * @param type $id
     * @return type
     * @throws type
     */
    function editEsnerAction(Request $request, $id) {
        
        $em = $this->getDoctrine()->getManager();
        $member = $em->getRepository('ESNMembersBundle:Member')->find($id);
        $esner = $em->getRepository('ESNMembersBundle:Esner')->findOneByMember($member);
        $infoEsner = $em->getRepository('ESNHRBundle:InfoEsner')->findOneByEsner($esner);

        if (!$member) {
            throw $this->createNotFoundException(
                'Aucun esner trouvé pour cet id : '.$id
            );
        }

        $form = $this->get('form.factory')->create(new InfoEsnerType($em, $esner->getId()));
        $formHandler = new InfoESNerHandler($em, $form, $request);
        $form->handleRequest($request);

        $process = $formHandler->process();
        if ($process) {
            $request->getSession()->getFlashBag()->add('notice', 'ESNer updated');
            return $this->redirect($this->generateUrl('esn_hr_association'));
        }

        return $this->render('ESNHRBundle:Association:edit.html.twig', array(
            'esner'     => $esner,
            'infoEsner' => $infoEsner,
            'type' => "association",
            'form' => $form->createView(),
        ));
    }
}