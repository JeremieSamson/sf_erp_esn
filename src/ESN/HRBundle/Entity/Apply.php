<?php

namespace ESN\HRBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ESN\AdministrationBundle\Entity\Country;

/**
 * Apply
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESN\HRBundle\Entity\ApplyRepository")
 */
class Apply {

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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;
    
     /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */    
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity="ESN\AdministrationBundle\Entity\Country", inversedBy="applies", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nationality;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    private $facebook_id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="student", type="boolean")
     */
    private $student = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="olderasmus", type="boolean")
     */
    private $olderasmus = false;

    /**
     * @var string
     *
     * @ORM\Column(name="motivation",nullable=true, type="text")
     */
    private $motivation;
    
    /**
     * @var string
     *
     * @ORM\Column(name="skill", nullable=true, type="text")
     */
    private $skill;
    
    /**
     * @var string
     *
     * @ORM\Column(name="knowEsn", nullable=true, type="text")
     */
    private $knowEsn;

    /**
     * @var integer
     *
     * @ORM\Column(name="availabletime", type="integer")
     */
    private $availabletime;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ESN\AdministrationBundle\Entity\Country", cascade={"persist"})
     */
    private $languages;

    /**
     * Constructor
     */
    public function __constructor(){
        $this->languages = new ArrayCollection();
    }

    /**
     * Return fullname
     *
     * @return string
     */
    public function __toString(){
        return $this->getFirstname() . " " . $this->getLastname();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setBirthdate(\DateTime $date)
    {
        $this->birthdate = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthdate;
    }

    /**
     * @param $motivation
     * @return $this
     */
    public function setMotivation($motivation)
    {
        $this->motivation = $motivation;

        return $this;
    }

    /**
     * @return string
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * @param $skill
     * @return $this
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return string
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param $knowEsn
     *
     * @return $this
     */
    public function setKnowEsn($knowEsn)
    {
        $this->knowEsn = $knowEsn;

        return $this;
    }

    /**
     * @return string
     */
    public function knowEsn()
    {
        return $this->knowEsn;
    }

    /**
     * @return Country
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param Country $nationality
     */
    public function setNationality(Country $nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * @param string $facebook_id
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
    }

    /**
     * @return boolean
     */
    public function isStudent()
    {
        return $this->student;
    }

    /**
     * @param boolean $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return boolean
     */
    public function isOlderasmus()
    {
        return $this->olderasmus;
    }

    /**
     * @param boolean $olderasmus
     */
    public function setOlderasmus($olderasmus)
    {
        $this->olderasmus = $olderasmus;
    }

    /**
     * @param Country $language
     *
     * @return $this
     */
    public function addLanguage(Country $language)
    {
        $this->languages->add($language);

        return $this;
    }

    /**
     * @param Country $language
     */
    public function removelanguage(Country $language)
    {
        $this->languages->removeElement($language);
    }

    /**
     * @return ArrayCollection
     */
    public function getLanguagess()
    {
        return $this->languages;
    }

    /**
     * @return int
     */
    public function getAvailabletime()
    {
        return $this->availabletime;
    }

    /**
     * @param int $availabletime
     */
    public function setAvailabletime($availabletime)
    {
        $this->availabletime = $availabletime;
    }

    /**
     * @return ArrayCollection
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param ArrayCollection $languages
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;
    }

    /**
     * Calculate Age
     *
     * @return string
     */
    public function getAge(){
        $date = new \DateTime($this->getBirthdate()->format('Y-m-d'));
        $now = new \DateTime();
        $interval = $now->diff($date);
        return $interval->y;
    }
}
