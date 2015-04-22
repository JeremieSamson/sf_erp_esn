<?php

namespace ESN\AdministrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ESN\MembersBundle\Entity\Esner;

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
     * @ORM\OneToMany(targetEntity="ESN\MembersBundle\Entity\Esner", mappedBy="pole")
     */
    private $esners;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="text")
     */
    private $color;

    public function __construct()
    {
        $this->esners = new ArrayCollection();
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
     * Set nbEsners
     *
     * @param integer $nbEsners
     * @return Pole
     */
    public function setNbEsners($nbEsners)
    {
        $this->nbEsners = $nbEsners;

        return $this;
    }

    /**
     * Get nbEsners
     *
     * @return integer 
     */
    public function getNbEsners()
    {
        return $this->nbEsners;
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

    public function addEsner(Esner $esner)
    {
        $this->esners[] = $esner;
        $esner->setPole($this);
        return $this;
    }

    public function removeEsner(Esner $esner)
    {
        $this->esners->removeElement($esner);
    }

    public function getEsners()
    {
        return $this->esners;
    }

    public function __toString(){
        return $this->getName();
    }
}
