<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 22:53
 */

namespace ESN\MembersBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Entity\EsnerFollow;
use ESN\UserBundle\Entity\User;
use FOS\UserBundle\Mailer\Mailer;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class EsnerHandler
{
    protected $em;
    protected $form;
    protected $request;

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
     * Initialize the handler with the form and the request.
     * @param
     * @param Form    $form
     * @param Request $request
     * @param $mailer
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

                /** @var User $user */
                $user = $this->form->getData();

                if ($this->form->has('sendmail') && $this->form->get('sendmail')->getData()){
                    $this->sendEmail($user);
                }

                if ($this->form->has('trial') && $this->form->get('trial')->getData()){
                    $follow = new EsnerFollow();
                    $follow->setTrialstarted($this->form->get('trial')->getData());

                    $this->em->persist($follow);

                    $user->setFollow($follow);
                }

                $this->onSuccess($user);

                return true;
            }
        }
        return false;
    }

    /**
     * @param User $user
     */
    protected function onSuccess(User $user){

        if (!$user->getId()){
            $user->setUsername($user->getEmail());
            $user->setRandomPassword();
            $user->setEsner(true);
            $user->setEnabled(true);

            $this->em->persist($user);
        }

        $this->em->flush();
    }

    /**
     * Send email to user
     *
     * @param User $user
     */
    private function sendEmail(User $user){
        $message = \Swift_Message::newInstance()
            ->setSubject('[ESN Lille] Bienvenue dans l\'association')
            ->setFrom($this->container->getParameter('mailer_from'))
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'ESNHRBundle:Emails:registration.html.twig',
                    array('user' => $user)
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}