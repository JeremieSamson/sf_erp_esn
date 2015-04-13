<?php

namespace ESN\MembersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;

/**
 * Member
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESN\MembersBundle\Entity\MemberRepository")
 */
class Member
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=30)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=5, nullable=true)
     */
    private $sexe;

    /**
     * @var \Date
     *
     * @ORM\Column(name="inscription", type="date", nullable=true)
     */
    private $inscription;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var integer
     *
     * @ORM\Column(name="university", type="integer", nullable=true)
     */
    private $university;

    /**
     * @var string
     *
     * @ORM\Column(name="study", type="string", length=255, nullable=true)
     */
    private $study;
    
    /**
     * 
     * @var \DateTime
     * 
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;
    
    /**
     *
     * @var integer
     *
     * @ORM\Column(name="nationality", type="integer", nullable=true)
     */
    private $nationality;

    /**
     *
     * @ORM\OneToMany(targetEntity="ESN\PermanenceBundle\Entity\ParticipateTrip", mappedBy="trip", cascade="persist")
     */
    public $trips;
    
    
    

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
     * @return Member
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
     * Set surname
     *
     * @param string $surname
     * @return Member
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Member
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Member
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set inscription
     *
     * @param \DateTime $inscription
     * @return Member
     */
    public function setInscription($inscription)
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get inscription
     *
     * @return \DateTime 
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Member
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set university
     *
     * @param integer $university
     * @return Member
     */
    public function setUniversity($university)
    {
        $this->university = $university;

        return $this;
    }

    /**
     * Get university
     *
     * @return integer 
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * Set study
     *
     * @param string $study
     * @return Member
     */
    public function setStudy($study)
    {
        $this->study = $study;

        return $this;
    }

    /**
     * Get study
     *
     * @return string 
     */
    public function getStudy()
    {
        return $this->study;
    }
    

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Member
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }
    
    public function getAge() {
        $birthday = $this->getBirthday();

        if (!is_null($birthday))
            return date_format(new DateTime(),'Y') - date_format($birthday, 'Y');

        return -1;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     * @return Member
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string 
     */
    public function getNationality()
    {
        return $this->nationality;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trips = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add trips
     *
     * @param \ESN\PermanenceBundle\Entity\ParticipateTrip $trips
     * @return Member
     */
    public function addTrip(\ESN\PermanenceBundle\Entity\ParticipateTrip $trips)
    {
        $this->trips[] = $trips;

        return $this;
    }

    /**
     * Remove trips
     *
     * @param \ESN\PermanenceBundle\Entity\ParticipateTrip $trips
     */
    public function removeTrip(\ESN\PermanenceBundle\Entity\ParticipateTrip $trips)
    {
        $this->trips->removeElement($trips);
    }

    /**
     * Get trips
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrips()
    {
        return $this->trips;
    }
}
