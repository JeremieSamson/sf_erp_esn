<?php

namespace ESN\MembersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Erasmus
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESN\MembersBundle\Entity\ErasmusRepository")
 */
class Erasmus
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
     *
     * @var integer
     * 
     * @ORM\OneToOne(targetEntity="ESN\MembersBundle\Entity\Member", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false,name="id_member")
     */
    private $member;

    /**
     * @var string
     *
     * @ORM\Column(name="esncard", type="string", length=50)
     */
    private $esncard;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arrivalDate", type="date", nullable=true)
     */
    private $arrivalDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="leavingDate", type="date", nullable=true)
     */
    private $leavingDate;


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
     * Set esncard
     *
     * @param string $esncard
     * @return Erasmus
     */
    public function setEsncard($esncard)
    {
        $this->esncard = $esncard;

        return $this;
    }

    /**
     * Get esncard
     *
     * @return string 
     */
    public function getEsncard()
    {
        return $this->esncard;
    }

    /**
     * Set arrivalDate
     *
     * @param \DateTime $arrivalDate
     * @return Erasmus
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    /**
     * Get arrivalDate
     *
     * @return \DateTime 
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * Set leavingDate
     *
     * @param \DateTime $leavingDate
     * @return Erasmus
     */
    public function setLeavingDate($leavingDate)
    {
        $this->leavingDate = $leavingDate;

        return $this;
    }

    /**
     * Get leavingDate
     *
     * @return \DateTime 
     */
    public function getLeavingDate()
    {
        return $this->leavingDate;
    }

    /**
     * Set member
     *
     * @param \ESN\MembersBundle\Entity\Member $member
     * @return Erasmus
     */
    public function setMember(\ESN\MembersBundle\Entity\Member $member)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \ESN\MembersBundle\Entity\Member 
     */
    public function getMember()
    {
        return $this->member;
    }
}
