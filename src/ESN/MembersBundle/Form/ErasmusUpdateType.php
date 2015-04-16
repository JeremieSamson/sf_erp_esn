<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:04
 */

namespace ESN\MembersBundle\Form;

use Doctrine\ORM\EntityManager;
use ESN\AdministrationBundle\Entity\University;
use ESN\MembersBundle\Entity\Erasmus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ErasmusUpdateType extends AbstractType
{
    private $em;
    private $erasmus;

    public function __construct(EntityManager $em, Erasmus $erasmus)
    {
        $this->em = $em;
        $this->erasmus = $erasmus;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dataUni = 0;
        $dataCountry = 0;
        if ($this->erasmus != null){
            $dataCountry = $this->erasmus->getMember()->getNationality();
            $dataUni = $this->erasmus->getMember()->getUniversity();
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
            ->add('arrivalDate','date')
            ->add('leavingDate','date')
            ->add('esncard', 'text')
            ->add('study', 'text')
            ->add('id' , 'hidden', array('attr' => array( 'value' => $this->erasmus->getId())))
            ->add('university', 'entity' ,
                array('class' => 'ESNAdministrationBundle:University',
                      'choices' => $this->em->getRepository('ESNAdministrationBundle:University')->findAll(),
                      'data' => $dataUni)
                )
            ->add('country', 'entity' ,
                array('class' => 'ESNAdministrationBundle:Country',
                      'choices' => $this->em->getRepository('ESNAdministrationBundle:Country')->findAll(),
                      'data' => $dataCountry
                )
            );
    }


    public function getName()
    {
        return 'update_members';
    }
}