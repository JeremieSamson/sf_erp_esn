<?php

namespace ESN\UserBundle\Entity;

/**
 * Created by PhpStorm.
 * User: ylly
 * Date: 13/10/15
 * Time: 22:44
 */

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User extends BaseUser
{
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
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
        $this->galaxy_roles = $galaxy_roles;
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
}