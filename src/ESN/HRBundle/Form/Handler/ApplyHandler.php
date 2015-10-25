<?php

/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:01.
 */

namespace ESN\HRBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Entity\Apply;
use ESN\HRBundle\Entity\InfoEsner;
use ESN\MembersBundle\Entity\Esner;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use ESN\MembersBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Request;

class ApplyHandler
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
                /** @var Apply $apply */
                $apply = $this->form->getData();

                $apply_email = $this->em->getRepository('ESNHRBundle:Apply')->findOneByEmail($apply->getEmail());
                $apply_name  = $this->em->getRepository('ESNHRBundle:Apply')->findBy(array("firstname" => $apply->getFirstname(), "lastname" => $apply->getLastname()));

                if (!$apply_email && !$apply_name){
                    $this->onSuccess($apply);
                    return true;
                }else{
                    $this->container->get('session')->getFlashBag()->add(
                        'error',
                        'Vous êtes déjà enregistré dans notre base de données, il est inutile de postuler plusieurs fois.'
                    );
                }
            }
        }
        return false;
    }

    /**
     * @param Apply $apply
     */
    protected function onSuccess(Apply $apply){
        $this->em->persist($apply);
        $this->em->flush();

        $this->sendEmail($apply);
    }

    /**
     * Send email to application user
     *
     * @param Apply $apply
     */
    private function sendEmail(Apply $apply){
        /** @var \Swift_Message $message */
        $message = \Swift_Message::newInstance()
            ->setSubject('[ESN Lille] Candidature prise en compte')
            ->setFrom($this->container->getParameter('mailer_from'))
            ->setTo($apply->getEmail())
            ->setBody(
                $this->templating->render(
                    'ESNHRBundle:Emails:application.html.twig',
                    array('apply' => $apply)
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);

        $message = \Swift_Message::newInstance()
            ->setSubject('[ESN Lille] Candidature prise en compte')
            ->setFrom($this->container->getParameter('mailer_from'))
            ->setTo($apply->getEmail())
            ->setBody(
                $this->templating->render(
                    'ESNHRBundle:Emails:new_application.html.twig',
                    array('apply' => $apply)
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}
