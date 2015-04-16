<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:04
 */

namespace ESN\PermanenceBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use ESN\AdministrationBundle\Entity\University;
use ESN\MembersBundle\Entity\Erasmus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EnrollUserToTripType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trips', 'entity', array(
                'class' => 'ESNAdministrationBundle:Trip',
                'property' => 'name'))
            ->add('members', 'entity', array(
                'class' => 'ESNMembersBundle:Member',
                'property' => 'name'));
    }

    public function getName()
    {
        return 'enroll_user_to_trip';
    }
}