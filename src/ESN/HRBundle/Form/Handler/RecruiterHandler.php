<?php

/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:01.
 */

namespace ESN\HRBundle\Form\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use ESN\UserBundle\Entity\User;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class RecruiterHandler
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Twig
     *
     * @var TwigEngine
     */
    protected $templating;

    /**
     * Mailer
     *
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @param EntityManager $em
     * @param Form $form
     * @param Request $request
     * @param ContainerInterface $container
     * @param TwigEngine $templating
     * @param \Swift_Mailer $mailer
     */
    public function __construct(EntityManager $em, Form $form, Request $request, ContainerInterface $container, TwigEngine $templating, \Swift_Mailer $mailer)
    {
        $this->em = $em;
        $this->form = $form;
        $this->request = $request;
        $this->container = $container;
        $this->templating = $templating;
        $this->mailer = $mailer;
    }

    public function process()
    {
        if ($this->form->isValid()) {
            if ('POST' == $this->request->getMethod()) {
                $recruiters = $this->em->getRepository('ESNUserBundle:User')->findRecruiters();

                /** @var ArrayCollection $recruiters_selected */
                $recruiters_selected = $this->form->get('esner')->getData();

                /** @var User $recruiter */
                foreach($recruiters as $recruiter) {
                    if (!$recruiters_selected->contains($recruiter)){
                        $recruiter->removeRole(User::ROLE_RECRUITER);
                    }
                }

                $this->onSuccess($recruiters_selected);

                $this->em->flush();

                return true;
            }
        }

        return false;
    }

    /**
     * @param ArrayCollection $esners
     */
    protected function onSuccess(ArrayCollection $esners)
    {
        /** @var User $esner */
        foreach ($esners as $esner) {
            $esner->addRole(User::ROLE_RECRUITER);

            $this->sendEmail($esner);
        }
    }

    /**
     * @param User $esner
     * @throws \Exception
     * @throws \Twig_Error
     */
    private function sendEmail(User $esner){
        /** @var \Swift_Message $message */
        $message = \Swift_Message::newInstance()
            ->setSubject('[ESN Lille] Recruteur')
            ->setFrom($this->container->getParameter('mailer_from'))
            ->setTo($esner->getEmail())
            ->setBody(
                $this->templating->render(
                    'ESNHRBundle:Emails:recruiter.html.twig',
                    array('esner' => $esner)
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}
