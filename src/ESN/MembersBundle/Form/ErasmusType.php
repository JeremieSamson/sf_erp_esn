<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:04
 */

namespace ESN\MembersBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use ESN\AdministrationBundle\Entity\University;
use ESN\MembersBundle\Entity\Erasmus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ErasmusType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
            ->add('surname','text')
            ->add('email','email')
            ->add('phone','text')
            ->add('birthday', 'date', array('widget' => 'single_text'))
            ->add('arrivalDate', 'date', array('widget' => 'single_text'))
            ->add('leavingDate', 'date', array('widget' => 'single_text'))
            ->add('esncard', 'text')
            ->add('study', 'text')
            ->add('university', 'entity' , array('class' => 'ESNAdministrationBundle:University', 'choices' => $this->em->getRepository('ESNAdministrationBundle:University')->findAll()))
            ->add('country', 'entity' , array('class' => 'ESNAdministrationBundle:Country', 'choices' => $this->em->getRepository('ESNAdministrationBundle:Country')->findAll()));
    }

    public function getName()
    {
        return 'create_members';
    }
}