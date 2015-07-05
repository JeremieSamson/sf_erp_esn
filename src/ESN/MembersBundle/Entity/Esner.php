<?php

namespace ESN\MembersBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\JoinColumn(nullable=true)
     */
    private $pole;

    /**
     * @ORM\ManyToOne(targetEntity="ESN\AdministrationBundle\Entity\Post", inversedBy="esners", cascade="persist")
     * @ORM\JoinColumn(nullable=true)
     */
    private $post;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="hascare", type="boolean", nullable=true)
     */
    private $hasCare = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = 1;

    /**
     * @ORM\ManyToOne(targetEntity="ESN\AdministrationBundle\Entity\Country", inversedBy="erasmusProgramme_esners", cascade="persist")
     * @ORM\JoinColumn(nullable=true)
     */
    private $erasmusProgramme;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="erasmus_year_start", type="date", nullable=true)
     */
    private $erasmus_year_start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="erasmus_year_end", type="date", nullable=true)
     */
    private $erasmus_year_end;

    /**
     * @var Esner
     *
     * @ORM\ManyToOne(targetEntity="ESN\MembersBundle\Entity\Esner", inversedBy="mentees")
     *
     */
    private $mentor;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ESN\MembersBundle\Entity\Esner", mappedBy="mentor")
     */
    private $mentees;

    public function __construct()
    {
        $this->mentees = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getErasmusProgramme()
    {
        return $this->erasmusProgramme;
    }

    /**
     * @param mixed $erasmusProgramme
     */
    public function setErasmusProgramme($erasmusProgramme)
    {
        $this->erasmusProgramme = $erasmusProgramme;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasCare()
    {
        return $this->hasCare;
    }

    /**
     * @param boolean $hasCare
     */
    public function setHasCare($hasCare)
    {
        $this->hasCare = $hasCare;
    }


    /**
     * @return \DateTime
     */
    public function getErasmusYearStart()
    {
        return $this->erasmus_year_start;
    }

    /**
     * @param \DateTime $erasmus_year_start
     */
    public function setErasmusYearStart($erasmus_year_start)
    {
        $this->erasmus_year_start = $erasmus_year_start;
    }

    /**
     * @return \DateTime
     */
    public function getErasmusYearEnd()
    {
        return $this->erasmus_year_end;
    }

    /**
     * @param \DateTime $erasmus_year_end
     */
    public function setErasmusYearEnd($erasmus_year_end)
    {
        $this->erasmus_year_end = $erasmus_year_end;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return Esner
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * @param Esner $mentor
     */
    public function setMentor(Esner $mentor)
    {
        $this->mentor = $mentor;
    }

    /**
     * @param \ESN\MembersBundle\Entity\Esner $esner
     *
     * @return $this
     */
    public function addMentee(Esner $esner)
    {
        $this->mentees->add($esner);

        $esner->setMentor($this);

        return $this;
    }

    /**
     * @param \ESN\MembersBundle\Entity\Esner $esner
     */
    public function removeMentee(Esner $esner)
    {
        $this->mentees->removeElement($esner);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getMentees()
    {
        return $this->mentees;
    }
}
