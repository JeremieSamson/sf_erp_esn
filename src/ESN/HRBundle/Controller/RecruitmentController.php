<?php

namespace ESN\HRBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Entity\Apply;
use ESN\HRBundle\Form\Handler\ApplyHandler;
use ESN\HRBundle\Form\Type\ApplyType;
use ESN\HRBundle\Form\Type\RecruiterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class RecruitmentController extends Controller {

    /**
     * List all current application
     *
     * @throws createAccessDeniedException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        if (!$this->getUser()->hasPermissionFor('human-ressources')){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var ArrayCollection $applies */
        $applies = $em->getRepository('ESNHRBundle:Apply')->findAll();

        return $this->render('ESNHRBundle:Recruitment:list.html.twig', array(
            'applies' => $applies
        ));
    }
    
    /**
     * Voir les applies
     *
     * @param integer $apply_id
     *
     * @throws createAccessDeniedException
     *
     * @return mixed
     */
    public function viewApplyAction($apply_id) {
        if (!$this->getUser()->hasPermissionFor('human-ressources')){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var ArrayCollection $applies */
        $apply = $em->getRepository('ESNHRBundle:Apply')->find($apply_id);

        if (!$apply){
            throw $this->createNotFoundException('Cette application n\'existe pas');
        }

        return $this->render('ESNHRBundle:Recruitment:detail.html.twig', array(
            'apply' => $apply
        ));
    }
    
    /**
     * Supprimer un apply dont l'id est passé en parametre
     *
     * @param integer $id
     *
     * @return mixed
     *
     * @throws createAccessDeniedException
     */
    public function deleteApplyAction($apply_id) {
        if (!$this->getUser()->hasPermissionFor('human-ressources')){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var ArrayCollection $applies */
        $apply = $em->getRepository('ESNHRBundle:Apply')->find($apply_id);

        if (!$apply){
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$apply_id
            );
        }

        $this->get('session')->getFlashBag()->add(
            'notice',
            "L'application de " .$apply. " a bien été supprimé"
        );

        $em->remove($apply);
        $em->flush();

        return $this->redirect($this->generateUrl('esn_hr_recruitment'));
    }

    /**
     * Create Apply Action
     *
     * @param Request $request
     *
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

    public function addRecruiterAction(Request $request){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->get('form.factory')->create(new RecruiterType());
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
