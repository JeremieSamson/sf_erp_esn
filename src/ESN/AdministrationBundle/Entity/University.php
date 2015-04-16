<?php

namespace ESN\AdministrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ESN\MembersBundle\Entity\Member;

/**
 * University
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class University
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
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="cigle", type="text")
     */
    private $cigle;

    /**
     * @ORM\OneToMany(targetEntity="ESN\MembersBundle\Entity\Member", mappedBy="university")
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
     * @return University
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
     * @return string
     */
    public function getCigle()
    {
        return $this->cigle;
    }

    /**
     * @param string $cigle
     */
    public function setCigle($cigle)
    {
        $this->cigle = $cigle;
    }

    public function __toString(){
        return (string) $this->getName();
    }

    public function addMember(Member $member)
    {
        $this->members[] = $member;
        $member->setUniversity($this);
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
