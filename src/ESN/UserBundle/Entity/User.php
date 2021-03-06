<?php

namespace ESN\UserBundle\Entity;

/**
 * Created by PhpStorm.
 * User: ylly
 * Date: 13/10/15
 * Time: 22:44
 */

use Doctrine\Common\Collections\ArrayCollection;
use ESN\AdministrationBundle\Entity\Activity;
use ESN\PermanenceBundle\Entity\PermanenceReport;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 * @ORM\Entity(repositoryClass="ESN\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    const ROLE_RECRUITER = "Local.recruiter";

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=5, nullable=true)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="galaxy_roles", type="text", nullable=true)
     */
    private $galaxy_roles;

    /**
     * @var string
     *
     * @ORM\Column(name="section", type="string", length=255, nullable=true)
     */
    private $section;

    /**
     * @var string
     *
     * @ORM\Column(name="code_section", type="string", length=255, nullable=true)
     */
    private $code_section;

    /**
     * @var string
     *
     * @ORM\Column(name="galaxy_picture", type="string", length=255, nullable=true)
     */
    private $galaxy_picture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=13, nullable=true)
     */
    private $mobile;

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
    private $hasCare = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = true;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="ESN\UserBundle\Entity\User", inversedBy="mentees")
     *
     */
    private $mentor;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ESN\UserBundle\Entity\User", mappedBy="mentor")
     */
    private $mentees;

    /**
     * @var string
     *
     * @ORM\Column(name="esncard", type="string", length=50, nullable=true)
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
     * @var boolean
     *
     * @ORM\Column(name="esner", type="boolean")
     */
    private $esner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inscription", type="date", nullable=true)
     */
    private $inscription;

    /**
     * @ORM\ManyToOne(targetEntity="ESN\AdministrationBundle\Entity\University", inversedBy="users", cascade="persist")
     */
    private $university;

    /**
     * @var string
     *
     * @ORM\Column(name="study", type="string", length=255, nullable=true)
     */
    private $study;

    /**
     * @ORM\ManyToOne(targetEntity="ESN\AdministrationBundle\Entity\Country", inversedBy="users", cascade="persist")
     * @ORM\JoinColumn(nullable=true)
     */
    private $nationality;

    /**
     * @var string
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    private $facebook_id;

    /**
     * @ORM\OneToOne(targetEntity="ESN\HRBundle\Entity\EsnerFollow", cascade={"persist"})
     */
    private $follow;

    /**
     * @ORM\OneToMany(targetEntity="ESN\PermanenceBundle\Entity\PermanenceReport", mappedBy="owner")
     */
    private $reports;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ESN\AdministrationBundle\Entity\Activity", mappedBy="user")
     */
    private $activities;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->mentees = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->activities = new ArrayCollection();
    }

    /**
     * return fullname
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getFirstname() . " " . $this->getLastname();
    }

    /**
     * return full object as string
     *
     * @return string
     */
    public function toLongString()
    {
        return "id:" . $this->getId() . ",firstname:" . $this->getFirstname() . ",lastname:" .$this->getLastname() . ",email:" . $this->getEmail();
    }

    /**
     * @return string
     */
    public function getFullname(){
        return $this->getFirstname() . " " . $this->getLastname();
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getGalaxyRoles()
    {
        return $this->galaxy_roles;
    }

    /**
     * @param mixed $galaxy_roles
     */
    public function setGalaxyRoles($galaxy_roles)
    {
        $recruiter = $this->isRecruiter();

        $this->galaxy_roles = $galaxy_roles;

        if ($recruiter) $this->addRole(USER::ROLE_RECRUITER);
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return string
     */
    public function getCodeSection()
    {
        return $this->code_section;
    }

    /**
     * @param string $code_section
     */
    public function setCodeSection($code_section)
    {
        $this->code_section = $code_section;
    }

    /**
     * @return string
     */
    public function getGalaxyPicture()
    {
        return $this->galaxy_picture;
    }

    /**
     * @param string $galaxy_picture
     */
    public function setGalaxyPicture($galaxy_picture)
    {
        $this->galaxy_picture = $galaxy_picture;
    }

    /**
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Calculate Age
     *
     * @return string
     */
    public function getAge(){
        if ($this->getBirthdate()){
            $date = new \DateTime($this->getBirthdate()->format('Y-m-d'));
            $now = new \DateTime();
            $interval = $now->diff($date);
            return $interval->y;
        }

        return null;
    }

    /**
     * @param \DateTime $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    public function setRandomPassword(){
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $this->setPlainPassword(implode($pass)); //turn the array into a string
    }

    /******************************************************************************************************************/

    /**
     * Check permission according to galaxy roles
     *
     * 1 => string 'National.webmaster' (length=18)
     * 2 => string 'Local.activeMember' (length=18)
     * 3 => string 'Local.regularBoardMember' (length=24)
     * 4 => string 'Local.webmaster' (length=15)
     * 5 => string 'National.projectCoordinator' (length=27)
     *
     * @param string $block
     *
     * @return bool
     */
    public function hasPermissionFor($block){
        if ($this->isSuperAdmin() || in_array('Local.president', explode(',', $this->getGalaxyRoles())))
            return true;

        switch($block){
            case 'dashboard' :
                return $this->isActiveMember();
            break;
            case 'treasury' :
                return $this->isVP() || $this->isTreasurer() || $this->isPresident();
            break;
            case 'human-ressources':
                return $this->isVP() || $this->isPresident();
            break;
            case 'administration':
                return $this->isVP() || $this->isWebmaster();
            break;
        }

        return false;
    }

    /**
     * Check if user is super admin
     *
     * @return bool
     */
    public function isSuperAdmin(){
        return in_array("ROLE_SUPER_ADMIN", $this->getRoles());
    }

    /**
     * Check if user is VP
     *
     * @return bool
     */
    public function isVP(){
        return in_array('Local.vicePresident', explode(',', $this->getGalaxyRoles()));
    }

    /**
     * Check if user is Treasurer
     *
     * @return bool
     */
    public function isTreasurer(){
        return in_array('Local.treasurer', explode(',', $this->getGalaxyRoles()));
    }

    /**
     * Check if user is Recruter
     *
     * @return bool
     */
    public function isRecruiter(){
        return in_array('Local.recruiter', explode(',', $this->getGalaxyRoles()));
    }

    /**
     * @param string $role
     */
    public function addRole($role){
        if (!strpos($this->galaxy_roles, $role))
            $this->galaxy_roles = $this->galaxy_roles . ',' . $role;
    }

    /**
     * @param string $role
     */
    public function removeRole($role){
        if (strpos($this->galaxy_roles, $role))
            $this->galaxy_roles = str_replace(",$role", '', $this->galaxy_roles);
    }

    /**
     * Check if user is Webmaster
     *
     * @return bool
     */
    public function isWebmaster(){
        return in_array('Local.webmaster', explode(',', $this->getGalaxyRoles()));
    }

    /**
     * Check if user is President
     *
     * @return bool
     */
    public function isPresident(){
        return in_array('Local.president', explode(',', $this->getGalaxyRoles()));
    }

    /**
     * Check if user is Active Member
     *
     * @return bool
     */
    public function isActiveMember(){
        return in_array('Local.activeMember', explode(',', $this->getGalaxyRoles()));
    }

    /******************************************************************************************************************/

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param string $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return mixed
     */
    public function getPole()
    {
        return $this->pole;
    }

    /**
     * @param mixed $pole
     */
    public function setPole($pole)
    {
        $this->pole = $pole;
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
     * @return User
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * @param User $mentor
     */
    public function setMentor($mentor)
    {
        $this->mentor = $mentor;
    }

    /**
     * @return ArrayCollection
     */
    public function getMentees()
    {
        return $this->mentees;
    }

    /**
     * @param \ESN\UserBundle\Entity\User $esner
     *
     * @return $this
     */
    public function addMentee($esner)
    {
        $this->mentees->add($esner);

        $esner->setMentor($this);

        return $this;
    }

    /**
     * @param \ESN\UserBundle\Entity\User $esner
     */
    public function removeMentee(User $esner)
    {
        $this->mentees->removeElement($esner);
    }

    /**
     * @return string
     */
    public function getEsncard()
    {
        return $this->esncard;
    }

    /**
     * @param string $esncard
     */
    public function setEsncard($esncard)
    {
        $this->esncard = $esncard;
    }

    /**
     * @return \DateTime
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * @param \DateTime $arrivalDate
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;
    }

    /**
     * @return \DateTime
     */
    public function getLeavingDate()
    {
        return $this->leavingDate;
    }

    /**
     * @param \DateTime $leavingDate
     */
    public function setLeavingDate($leavingDate)
    {
        $this->leavingDate = $leavingDate;
    }

    /**
     * @return boolean
     */
    public function isEsner()
    {
        return $this->esner;
    }

    /**
     * @param boolean $esner
     */
    public function setEsner($esner)
    {
        $this->esner = $esner;
    }

    /**
     * @return boolean
     */
    public function isInternationalStudent()
    {
        return !$this->esner;
    }

    /**
     * @param boolean $value
     */
    public function setInternationalStudent($value)
    {
        $this->esner = !$value;
    }

    /**
     * @return \DateTime
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * @param \DateTime $inscription
     */
    public function setInscription($inscription)
    {
        $this->inscription = $inscription;
    }

    /**
     * @return mixed
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * @param mixed $university
     */
    public function setUniversity($university)
    {
        $this->university = $university;
    }

    /**
     * @return string
     */
    public function getStudy()
    {
        return $this->study;
    }

    /**
     * @param string $study
     */
    public function setStudy($study)
    {
        $this->study = $study;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
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
     * @return mixed
     */
    public function getFollow()
    {
        return $this->follow;
    }

    /**
     * @param mixed $follow
     */
    public function setFollow($follow)
    {
        $this->follow = $follow;
    }

    /**
     * @return ArrayCollection
     */
    public function getReports()
    {
        return $this->reports;
    }

    /**
     * @param \ESN\PermanenceBundle\Entity\PermanenceReport $report
     *
     * @return $this
     */
    public function addReport(PermanenceReport $report)
    {
        $this->reports->add($report);

        $report->setOwner($this);

        return $this;
    }

    /**
     * @param \ESN\PermanenceBundle\Entity\PermanenceReport $report
     */
    public function removeReport(PermanenceReport $report)
    {
        $this->reports->removeElement($report);
    }

    /**
     * @param Activity $activity
     *
     * @return $this
     */
    public function addActivity(Activity $activity){
        $this->activities->add($activity);

        $activity->setUser($this);

        return $this;
    }

    /**
     * @param Activity $activity
     */
    public function removeActivity(Activity $activity){
        $this->activities->removeElement($activity);
    }

    /**
     * @return ArrayCollection
     */
    public  function getActivities(){
        return $this->activities;
    }
}