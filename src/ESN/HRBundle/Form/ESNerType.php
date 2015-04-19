<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:04
 */

namespace ESN\HRBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ESNerType extends AbstractType
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
            ->add('university', 'entity' , array('class' => 'ESNAdministrationBundle:University', 'choices' => $this->em->getRepository('ESNAdministrationBundle:University')->findAll()))
            ->add('country', 'entity' , array('class' => 'ESNAdministrationBundle:Country', 'choices' => $this->em->getRepository('ESNAdministrationBundle:Country')->findAll()));
    }

    public function getName()
    {
        return 'create_members';
    }
}