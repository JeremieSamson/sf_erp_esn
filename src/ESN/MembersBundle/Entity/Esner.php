<?php

namespace ESN\MembersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ESN\AdministrationBundle\Entity\Pole;

/**
 * Esner
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESN\MembersBundle\Entity\EsnerRepository")
 */
class Esner
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
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var integer
     *
     * @ORM\Column(name="zipcode", type="integer", nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\ManyToOne(targetEntity="ESN\AdministrationBundle\Entity\Pole", inversedBy="esners", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pole;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hascare", type="boolean", nullable=true)
     */
    private $hasCare;

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
     * Set address
     *
     * @param string $address
     * @return Esner
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Esner
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipcode
     *
     * @param integer $zipcode
     * @return Esner
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return integer 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }
    
    

    /**
     * Set member
     *
     * @param \ESN\MembersBundle\Entity\Member $member
     * @return Esner
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

    /**
     * Set pole
     *
     * @param entity $pole
     * @return Esner
     */
    public function setPole(Pole $pole)
    {
        $this->pole = $pole;
        return $this;
    }

    /**
     * Get pole
     *
     * @return entity
     */
    public function getPole()
    {
        return $this->pole;
    }
}
