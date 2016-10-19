<?php

namespace ESN\HRBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Entity\Apply;
use ESN\HRBundle\Form\Handler\ApplyHandler;
use ESN\HRBundle\Form\Handler\RecruiterHandler;
use ESN\HRBundle\Form\Type\ApplyType;
use ESN\HRBundle\Form\Type\RecruiterType;
use ESN\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class RecruitmentController extends Controller {

    /**
     * List all current application
     *
     * @throws AccessDeniedException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {

        if (!$this->getUser()->hasPermissionFor('human-ressources') && !$this->getUser()->isRecruiter()){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var ArrayCollection $applies */
        $applies = $em->getRepository('ESNHRBundle:Apply')->findBy(array("archived" => false));

        $esners = $em->getRepository('ESNUserBundle:User')->findBy(array("esner" => true));

        return $this->render('ESNHRBundle:Recruitment:list.html.twig', array(
            'applies' => $applies,
            'esners'  => $esners
        ));
    }

    /**
     * After clicking on the bootstrap toogle confirmation
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function enrollAction(Request $request, $id)
    {
        if (!$this->getUser()->hasPermissionFor('human-ressources') && !$this->getUser()->isRecruiter()){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Apply $apply */
        $apply = $em->getRepository('ESNHRBundle:Apply')->find($id);

        if (!$apply) {
            throw $this->createNotFoundException();
        }

        /** @var User $esner */
        $esner_db = $em->getRepository('ESNUserBundle:User')->findUserByEmail($apply->getEmail());

        $esner = ($esner_db) ? $esner_db : new User();

        $esner->setFirstname($apply->getFirstname());
        $esner->setLastname($apply->getLastname());
        $esner->setEnabled(1);
        $esner->setEmail($apply->getEmail());
        $esner->setPlainPassword($esner->getEmail());
        $esner->setUsername($apply->getEmail());
        $esner->setUsernameCanonical($apply->getEmail());
        $esner->setBirthdate($apply->getBirthDate());
        $esner->setActive(true);
        $esner->setEsner(true);
        $esner->setMobile(str_replace(' ', '', $apply->getMobile()));

        $em->persist($esner);

        $apply->setArchived(true);

        $em->flush();

        $msg = ($esner_db) ? "Le compte ESNer de " . $apply->getFirstname() . " a bien été mis à jours" : $apply->getFirstname() . " a bien été passé en ESNer";
        $this->addFlash('notice', $msg);

        return $this->redirectToRoute('esn_hr_recruitment');
    }
    
    /**
     * Voir les applies
     *
     * @param integer $apply_id
     *
     * @throws AccessDeniedException
     *
     * @return mixed
     */
    public function viewApplyAction($apply_id) {
        if (!$this->getUser()->hasPermissionFor('human-ressources') && !$this->getUser()->isRecruiter()){
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
     * @throws AccessDeniedException
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

        $this->addFlash('notice', "La fiche de recrutement de " .$apply. " a bien été supprimé");

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
        if (!$this->getUser()->hasPermissionFor('human-ressources')){
            throw $this->createAccessDeniedException('Vous n\'êtes pas authorisé à acceder à cette page');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->get('form.factory')->create(new RecruiterType($em));
        $formHandler = new RecruiterHandler($em, $form, $request, $this->container, $this->get('templating'), $this->get('mailer'));
        $form->handleRequest($request);

        if ($formHandler->process())
        {
            $this->get('session')->getFlashBag()->add(
                'notice', "La mise à jours des recruteurs à bien été effectué.  "
            );

            return $this->redirect($this->generateUrl('esn_hr_recruitment'));
        }

        return new JsonResponse(array(
            'html' => $this->renderView(
                'ESNHRBundle:Recruitment:popup_esner.html.twig',
                array(
                    'form' => $form->createView()
                )
            ),
        ));
    }
}
