<?php

namespace ESN\HRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoEsner
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESN\HRBundle\Entity\InfoEsnerRepository")
 */
class InfoEsner 
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
     * @ORM\OneToOne(targetEntity="ESN\MembersBundle\Entity\Esner", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false,name="id_esner")
     */
    private $esner;
    
     /**
     * @var \Date
     *
     * @ORM\Column(name="cotisation",nullable=true, type="date")
     */
    private $cotisation;
    
     /**
     * @var string
     *
     * @ORM\Column(name="comment",nullable=true, type="string", length=255)
     */
    private $comment;
    
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
     * Set esner
     *
     * @param \Esner $esner
     * @return \Esner
     */
    public function setEsner($esner)
    {
        $this->esner = $esner;

        return $this;
    }

    /**
     * Get esner
     *
     * @return \Esner 
     */
    public function getEsner()
    {
        return $this->esner;
    }
    
    /**
     * Set cotisation
     *
     * @param \DateTime $cotisation
     * @return \Datetime
     */
    public function setCotisation($cotisation)
    {
        $this->cotisation = $cotisation;

        return $this;
    }

    /**
     * Get cotisation
     *
     * @return \DateTime 
     */
    public function getCotisation()
    {
        return $this->cotisation;
    }
    
    /**
     * Set comment
     *
     * @param String $comment
     * @return String
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return String 
     */
    public function getComment()
    {
        return $this->comment;
    }
    
}
