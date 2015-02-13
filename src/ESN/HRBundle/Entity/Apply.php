<?php

namespace ESN\HRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="name",nullable=true, type="string", length=255)
     */
    private $name;
    
     /**
     * @var string
     *
     * @ORM\Column(name="surname",nullable=true, type="string", length=255)
     */    
    private $surname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email",nullable=true, type="string", length=255)
     */
    private $email;
    
    /**
     *
     * @var Date 
     * 
     * @ORM\Column(name="date", nullable=true, type="date")
     */
    private $date;
    
    /**
     * @var string
     *
     * @ORM\Column(name="motivation",nullable=true, type="string", length=255)
     */
    private $motivation;
    
    /**
     * @var string
     *
     * @ORM\Column(name="skill",nullable=true, type="string", length=255)
     */
    private $skill;
    
    /**
     * @var string
     *
     * @ORM\Column(name="knowEsn",nullable=true, type="string", length=255)
     */
    private $knowEsn;
    
    public function getId()
    {
        return $this->id;
    }
    
    
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    
     public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    public function getSurname()
    {
        return $this->surname;
    }  
    
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }  
    
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }  
    
    public function setMotivation($motivation)
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getMotivation()
    {
        return $this->motivation;
    }  
    
         public function setSkill($skill)
    {
        $this->skill = $skill;

        return $this;
    }

    public function getSkill()
    {
        return $this->skill;
    }  
    
         public function setKnowEsn($knowEsn)
    {
        $this->knowEsn = $knowEsn;

        return $this;
    }

    public function getKnowEsn()
    {
        return $this->knowEsn;
    }  
    
}
