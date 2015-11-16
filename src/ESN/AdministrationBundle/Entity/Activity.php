<?php

namespace ESN\AdministrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ESN\UserBundle\Entity\User;

/**
 * Activity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESN\AdministrationBundle\Entity\ActivityRepository")
 */
class Activity
{
    public static $ACTIONS = array("d" => "deleted", "c" => "created", "u" => "updated", "li" => "login", "lo" => "logout");

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
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="old", type="string", length=255, nullable=true)
     */
    private $old;

    /**
     * @var string
     *
     * @ORM\Column(name="new", type="string", length=255, nullable=true)
     */
    private $new;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="ESN\UserBundle\Entity\User", inversedBy="activities", cascade="all")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255)
     */
    private $action;

    /**
     * Constructor
     */
    public function __construct(){
        $this->setCreatedAt(new \DateTime('now'));
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Activity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set old
     *
     * @param string $old
     *
     * @return Activity
     */
    public function setOld($old)
    {
        $this->old = $old;

        return $this;
    }

    /**
     * Get old
     *
     * @return string
     */
    public function getOld()
    {
        return $this->old;
    }

    /**
     * Set new
     *
     * @param string $new
     *
     * @return Activity
     */
    public function setNew($new)
    {
        $this->new = $new;

        return $this;
    }

    /**
     * Get new
     *
     * @return string
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
}

