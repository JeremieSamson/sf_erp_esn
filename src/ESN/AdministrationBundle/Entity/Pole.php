<?php

namespace ESN\AdministrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pole
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Pole
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nb_members", type="integer", length=10)
     */
    private $nb_members;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Pole
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Pole
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set nb_members
     *
     * @param integer $nb_members
     * @return Pole
     */
    public function setNb_members($nb_members)
    {
        $this->nb_members = $nb_members;

        return $this;
    }

    /**
     * Get nb_members
     *
     * @return integer 
     */
    public function getNb_members()
    {
        return $this->nb_members;
    }
}
