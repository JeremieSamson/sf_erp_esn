<?php

namespace ESN\AdministrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ESN\UserBundle\Entity\User;

/**
 * Pole
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESN\AdministrationBundle\Entity\PoleRepository")
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
     * @ORM\OneToMany(targetEntity="ESN\UserBundle\Entity\User", mappedBy="pole")
     */
    private $esners;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="text")
     */
    private $color;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->esners = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(){
        return $this->getName();
    }

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
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @param User $esner
     * @return $this
     */
    public function addEsner(User $esner)
    {
        $this->esners->add($esner);
        $esner->setPole($this);
        return $this;
    }

    /**
     * @param User $esner
     */
    public function removeEsner(User $esner)
    {
        $this->esners->removeElement($esner);
    }

    /**
     * @return ArrayCollection
     */
    public function getEsners()
    {
        return $this->esners;
    }
}
