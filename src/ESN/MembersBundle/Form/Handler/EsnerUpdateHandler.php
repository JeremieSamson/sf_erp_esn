<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 22:53
 */

namespace ESN\MembersBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use ESN\MembersBundle\Entity\Erasmus;
use Symfony\Component\Form\Form;
use ESN\MembersBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Request;

class EsnerUpdateHandler
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
        if ($this->form->isValid()) {
            if ('POST' == $this->request->getMethod()) {

                $esner = $this->em->getRepository('ESNMembersBundle:Esner')->find($this->form->get('id')->getData());
                $member = $this->em->getRepository('ESNMembersBundle:Member')->find($esner->getMember());
                $member->setName($this->form->get('name')->getData());
                $member->setSurname($this->form->get('surname')->getData());
                $member->setEmail($this->form->get('email')->getData());
                $member->setPhone($this->form->get('phone')->getData());
                $member->setStudy($this->form->get('study')->getData());
                $member->setBirthday($this->form->get('birthday')->getData());
                $member->setUniversity($this->form->get('university')->getData());
                $member->setNationality($this->form->get('country')->getData());
                $member->setFacebookId($this->form->get('facebook_id')->getData());

                $esner->setMember($member);
                $esner->setAddress($this->form->get('address')->getData());
                $esner->setCity($this->form->get('city')->getData());
                $esner->setZipcode($this->form->get('zipcode')->getData());
                $esner->setErasmusProgramme($this->form->get('erasmus')->getData());
                $esner->setErasmusYearStart($this->form->get('erasmusyearstart')->getData());
                $esner->setErasmusYearEnd($this->form->get('erasmusyearend')->getData());
                $esner->setHasCare($this->form->get('hasCare')->getData());
                $esner->setPost($this->form->get('post')->getData());
                $esner->setPole($this->form->get('pole')->getData());
                $this->em->flush();

                return true;
            }
        }
        return false;
    }

    protected function onSuccess(){
    }
}