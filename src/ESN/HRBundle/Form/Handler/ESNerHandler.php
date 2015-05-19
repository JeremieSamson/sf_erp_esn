<?php

/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:01.
 */

namespace ESN\HRBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Entity\InfoEsner;
use ESN\MembersBundle\Entity\Esner;
use Symfony\Component\Form\Form;
use ESN\MembersBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Request;

class ESNerHandler
{
    protected $em;
    protected $request;
    protected $form;

    /**
     * Initialize the handler with the form and the request.
     * @param
     * @param Form    $form
     * @param Request $request
     * @param $mailer
     */
    public function __construct(EntityManager $em, Form $form, Request $request)
    {
        $this->em = $em;
        $this->form = $form;
        $this->request = $request;
    }

    public function process()
    {
        if ('POST' == $this->request->getMethod()) {
            $member = new Member();
            $member->setName($this->form->get('name')->getData());
            $member->setSurname($this->form->get('surname')->getData());
            $member->setEmail($this->form->get('email')->getData());
            $member->setPhone($this->form->get('phone')->getData());
            $member->setUniversity($this->form->get('university')->getData());
            $member->setNationality($this->form->get('country')->getData());
            $member->setInscription(new \DateTime());
            $member->setFacebookId($this->form->get('facebook_id')->getData());
            $this->em->persist($member);

            $esner = new Esner();
            $esner->setMember($member);
            $esner->setPole($this->form->get('pole')->getData());
            $esner->setErasmusProgramme($this->form->get('erasmus')->getData());
            $esner->setPost($this->form->get('post')->getData());

            $infoEsner = new InfoEsner();
            $infoEsner->setEsner($esner);

            $this->em->persist($esner);
            $this->em->persist($infoEsner);
            $this->em->flush();

            return true;
        }

        return false;
    }

    protected function onSuccess(){
    }
}
