<?php

namespace ESN\HRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EsnerFollow
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESN\AdministrationBundle\Entity\EsnerFollowRepository")
 */
class EsnerFollow
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
     * @var \DateTime
     *
     * @ORM\Column(name="trialstarted", type="datetime")
     */
    private $trialstarted;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
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
     * Set trialstarted
     *
     * @param \DateTime $trialstarted
     *
     * @return EsnerFollow
     */
    public function setTrialstarted($trialstarted)
    {
        $this->trialstarted = $trialstarted;

        return $this;
    }

    /**
     * Get trialstarted
     *
     * @return \DateTime
     */
    public function getTrialstarted()
    {
        return $this->trialstarted;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return EsnerFollow
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}

