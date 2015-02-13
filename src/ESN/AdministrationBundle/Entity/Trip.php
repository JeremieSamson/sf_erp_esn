<?php

namespace ESN\AdministrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trip
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Trip
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
     * @ORM\Column(name="name", type="string")
     */
    private $name;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_place", type="integer")
     */
    private $nbPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    
    /**
    * @ORM\Column(type="decimal", scale=2)
    */
    private $price;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="ESN\PermanenceBundle\Entity\ParticipateTrip", mappedBy="member", cascade="persist")
     */
    public $members;
    
    

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
     * @return Trip
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
     * Set date
     *
     * @param \DateTime $date
     * @return Trip
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nbPlace
     *
     * @param integer $nbPlace
     * @return Trip
     */
    public function setNbPlace($nbPlace)
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * Get nbPlace
     *
     * @return integer 
     */
    public function getNbPlace()
    {
        return $this->nbPlace;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Trip
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
     * Set prix
     *
     * @param string $prix
     * @return Trip
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Trip
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add members
     *
     * @param \ESN\PermanenceBundle\Entity\ParticipateTrip $members
     * @return Trip
     */
    public function addMember(\ESN\PermanenceBundle\Entity\ParticipateTrip $members)
    {
        $this->members[] = $members;

        return $this;
    }

    /**
     * Remove members
     *
     * @param \ESN\PermanenceBundle\Entity\ParticipateTrip $members
     */
    public function removeMember(\ESN\PermanenceBundle\Entity\ParticipateTrip $members)
    {
        $this->members->removeElement($members);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMembers()
    {
        return $this->members;
    }
}
