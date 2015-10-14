<?php
/**
 * Created by PhpStorm.
 * User: Jérémie Samson | jeremie@ylly.fr
 * Date: 29/04/15
 * Time: 23:34
 */

namespace ESN\AdministrationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ESN\MembersBundle\Entity\Esner;
use ESN\UserBundle\Entity\User;

/**
 * Rule
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ESN\AdministrationBundle\Entity\PostRepository")
 */
class Post {
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ESN\UserBundle\Entity\User", mappedBy="post")
     */
    private $esners;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->esners = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(){
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param User $esner
     * @return $this
     */
    public function addEsner(User $esner)
    {
        $this->esners->add($esner);
        $esner->setPost($this);
        return $this;
    }

    /**
     * @param User $esner
     */
    public function removeEsner(User $esner)
    {
        $this->esners->removeElement($esner);
    }

    /**
     * @return ArrayCollection
     */
    public function getEsners()
    {
        return $this->esners;
    }
}