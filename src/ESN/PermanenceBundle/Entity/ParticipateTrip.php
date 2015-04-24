<?php

namespace ESN\PermanenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ESN\AdministrationBundle\Entity\Trip;
use ESN\MembersBundle\Entity\Member;

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
   * @ORM\ManyToOne(targetEntity="ESN\AdministrationBundle\Entity\Trip", inversedBy="members")
   * @ORM\JoinColumn(name="trip", referencedColumnName="id")
   */
    public $trip; 
    
    /**
    * @ORM\ManyToOne(targetEntity="ESN\MembersBundle\Entity\Member", inversedBy="trips")
    * @ORM\JoinColumn(name="member", referencedColumnName="id")
    */
    public $member; 
     
    /**
     * @ORM\Column(name="dateInscription", type="datetime")
     */
    private $dateInscription;
    
    
    public function __construct()
    {
        $this->dateInscription = new \DateTime();
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set trip
     *
     * @param \ESN\AdministrationBundle\Entity\Trip $trip
     * @return ParticipateTrip
     */
    public function setTrips(Trip $trip = null)
    {
        $this->trip = $trip;

        return $this;
    }

    /**
     * Get trip
     *
     * @return \ESN\AdministrationBundle\Entity\Trip 
     */
    public function getTrips()
    {
        return $this->trip;
    }

    /**
     * Set member
     *
     * @param \ESN\MembersBundle\Entity\Member $member
     * @return ParticipateTrip
     */
    public function setMembers(Member $member = null)
    {
        $this->member = $member;
        return $this;
    }

    /**
     * Get member
     *
     * @return \ESN\MembersBundle\Entity\Member 
     */
    public function getMembers()
    {
        return $this->member;
    }

     public function __toString(){
         return  $this->getTrips()->getName();
     }
}
