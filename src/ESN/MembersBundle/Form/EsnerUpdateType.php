<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 15/04/15
 * Time: 22:45
 */

namespace ESN\MembersBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use ESN\AdministrationBundle\Entity\University;
use ESN\MembersBundle\Entity\Erasmus;
use ESN\MembersBundle\Entity\Esner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ESNerUpdateType extends AbstractType{
    private $em;
    private $esner;

    public function __construct(EntityManager $em, Esner $esner)
    {
        $this->em = $em;
        $this->esner = $esner;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dataUni = 0;
        $dataCountry = 0;
        if ($this->esner != null){
            $dataCountry = $this->esner->getMember()->getNationality();
            $dataUni = $this->esner->getMember()->getUniversity();
        }

        $choicesUni = array();
        foreach($this->em->getRepository('ESNAdministrationBundle:University')->findAll() as $university)
            $choicesUni[$university->getId()] = $university->getName();

        $choicesCountry = array();
        foreach($this->em->getRepository('ESNAdministrationBundle:Country')->findAll() as $country)
            $choicesCountry[$country->getId()] = $country->getNationality();

        $builder->add('name', 'text')
            ->add('surname','text')
            ->add('email','email')
            ->add('phone','text')
            ->add('birthday','date')
            ->add('study', 'text')
            ->add('address', 'text')
            ->add('city', 'text')
            ->add('zipcode', 'number')
            ->add('id' , 'hidden', array('attr' => array( 'value' => $this->esner->getId())))
            ->add('university', 'choice' , array('choices' => $choicesUni, 'data' => $dataUni))
            ->add('country', 'choice' , array('choices' => $choicesCountry, 'data' => $dataCountry));
    }


    public function getName()
    {
        return 'update_esners';
    }
}