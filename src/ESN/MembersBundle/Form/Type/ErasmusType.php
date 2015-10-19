<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:04
 */

namespace ESN\MembersBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use ESN\AdministrationBundle\Entity\CountryRepository;
use ESN\AdministrationBundle\Entity\University;
use ESN\AdministrationBundle\Entity\UniversityRepository;
use ESN\MembersBundle\Entity\Erasmus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ErasmusType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text')
            ->add('lastname','text')
            ->add('email','email', array("required" => false))
            ->add('mobile','text', array("required" => false))
            ->add('birthdate', 'date', array('widget' => 'single_text'))
            ->add('arrivalDate', 'date', array('widget' => 'single_text'))
            ->add('leavingDate', 'date', array('widget' => 'single_text'))
            ->add('esncard', 'text', array("required" => false))
            ->add('university', 'entity' , array(
                    'class' => 'ESNAdministrationBundle:University',
                    'empty_value'  => '',
                    'query_builder' => function(UniversityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy("u.name", "ASC");
                    }
                )
            )
            ->add('study', 'text', array("required" => false))
            ->add('nationality', 'entity', array(
                    'class' => 'ESNAdministrationBundle:Country',
                    'empty_value'  => '',
                    'choices' => function(CountryRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy("c.name", "ASC");
                    }
                )
            );
    }

    public function getName()
    {
        return 'erasmus_form';
    }
}