<?php

namespace ESN\PermanenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ESN\AdministrationBundle\Entity\Trip;
use ESN\MembersBundle\Entity\Member;
use ESN\UserBundle\Entity\User;

/**
 * ParticipateTrip
 *
 * @ORM\Table()
 * @ORM\Entity
 */
 class ParticipateTrip
{
      /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;
   
     /**
   * @ORM\ManyToOne(targetEntity="ESN\AdministrationBundle\Entity\Trip")
   * @ORM\JoinColumn(name="trip", referencedColumnName="id")
   */
    public $trip; 
    
    /**
    * @ORM\ManyToOne(targetEntity="ESN\UserBundle\Entity\User")
    * @ORM\JoinColumn(name="user", referencedColumnName="id")
    */
    public $user;
     
    /**
     * @ORM\Column(name="dateInscription", type="datetime")
     */
    private $dateInscription;

     /**
      * Constructor
      */
    public function __construct()
    {
        $this->dateInscription = new \DateTime();
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
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     * @return ParticipateTrip
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime 
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * Set trip
     *
     * @param \ESN\AdministrationBundle\Entity\Trip $trip
     * @return ParticipateTrip
     */
    public function setTrip(Trip $trip)
    {
        $this->trip = $trip;

        return $this;
    }

    /**
     * Get trip
     *
     * @return \ESN\AdministrationBundle\Entity\Trip 
     */
    public function getTrip()
    {
        return $this->trip;
    }

    /**
     * Set user
     *
     * @param \ESN\UserBundle\Entity\User $user
     * @return ParticipateTrip
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ESN\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
