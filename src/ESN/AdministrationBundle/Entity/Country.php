<?php

namespace ESN\AdministrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ESN\MembersBundle\Entity\Member;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity
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
     * @ORM\OneToMany(targetEntity="ESN\MembersBundle\Entity\Member", mappedBy="nationality")
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
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

    public function addMember(Member $member)
    {
        $this->members[] = $member;
        $member->setNationality($this);
        return $this;
    }

    public function removeMember(Member $member)
    {
        $this->members->removeElement($member);
    }

    public function getMembers()
    {
        return $this->members;
    }
}
