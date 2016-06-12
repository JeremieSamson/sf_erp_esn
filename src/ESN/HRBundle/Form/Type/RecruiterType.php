<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:04
 */

namespace ESN\HRBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use ESN\AdministrationBundle\Entity\CountryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RecruiterType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('esner', 'entity', array(
                'label' => false,
                'multiple'  => true,
                'class'     => 'ESNUserBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.esner = true')
                        ->andWhere('u.active = true')
                        ->addOrderBy('u.firstname', 'ASC')
                        ->addOrderBy('u.lastname', 'ASC')
                    ;
                },
                'data' => $this->fillRecruiters(),
            ))
        ;
    }

    public function fillRecruiters(){
        $users = $this->em->getRepository('ESNUserBundle:User')->findRecruiters();

        $recruiters = new ArrayCollection();
        foreach($users as $user){
            $recruiters->add($user);
        }

        return $recruiters;
    }

    public function getName()
    {
        return 'form_add_recruiter';
    }
}