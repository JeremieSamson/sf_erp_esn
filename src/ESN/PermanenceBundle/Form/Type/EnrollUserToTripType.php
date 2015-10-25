<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:04
 */

namespace ESN\PermanenceBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use ESN\AdministrationBundle\Entity\TripRepository;
use ESN\UserBundle\Entity\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EnrollUserToTripType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trip', 'entity', array(
                    'class' => 'ESNAdministrationBundle:Trip',
                    'empty_value'  => '',
                    'query_builder' => function(TripRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->orderBy("t.name", "ASC");
                    }
                )
            )
            ->add('user', 'entity', array(
                    'class' => 'ESNUserBundle:User',
                    'empty_value'  => '',
                    'query_builder' => function(UserRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy("u.firstname, u.lastname", "ASC");
                    }
                )
            );
    }

    public function getName()
    {
        return 'enroll_user_to_trip';
    }
}