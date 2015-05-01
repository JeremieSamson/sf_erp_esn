<?php
/**
 * Created by PhpStorm.
 * User: Jérémie Samson | jeremie@ylly.fr
 * Date: 18/04/15
 * Time: 15:59
 */

namespace ESN\HRBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InfoEsnerType extends AbstractType{

    private $em;
    private $id_esner;

    public function __construct(EntityManager $em, $id_esner)
    {
        $this->em = $em;
        $this->id_esner = $id_esner;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cotisation', 'date', array(
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                "required" => false
            ))
            ->add('comment', 'textarea', array("required" => false))
            ->add('active', 'checkbox', array("required" => false, "mapped" => false))
            ->add('id_esner', 'hidden', array('attr' => array('value' =>$this->id_esner)));
    }

    public function getName()
    {
        return 'create_info_esner';
    }
}