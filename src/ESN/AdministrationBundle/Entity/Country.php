<?php

namespace ESN\AdministrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ESN\UserBundle\Entity\User;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ESN\AdministrationBundle\Entity\CountryRepository")
 */
class Country
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=50)
     */
    private $nationality;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=50)
     */
    private $language;

    /**
     * @ORM\OneToMany(targetEntity="ESN\UserBundle\Entity\User", mappedBy="nationality")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="ESN\UserBundle\Entity\User", mappedBy="erasmusProgramme")
     */
    private $erasmusProgramme_esners;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->erasmusProgramme_esners = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Country
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
     * Set nationality
     *
     * @param string $nationality
     * @return Country
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
     * Set language
     *
     * @param string $language
     * @return Country
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function __toString(){
        return $this->name;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function addUser(User $user)
    {
        $this->users->add($user);
        $user->setNationality($this);
        return $this;
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function addEsner(User $esner)
    {
        $this->erasmusProgramme_esners[] = $esner;
        $esner->setErasmusProgramme($this);
        return $this;
    }

    public function removeEsner(User $esner)
    {
        $this->erasmusProgramme_esners->removeElement($esner);
    }

    public function getEsnerErasmusProgramme()
    {
        return $this->erasmusProgramme_esners;
    }
}
