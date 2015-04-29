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

/**
 * Rule
 *
 * @ORM\Table()
 * @ORM\Entity
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
     * @ORM\OneToMany(targetEntity="ESN\MembersBundle\Entity\Esner", mappedBy="post")
     */
    private $esners;


    public function __construct()
    {
        $this->esners = new ArrayCollection();
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

    public function addEsner(Esner $esner)
    {
        $this->esners[] = $esner;
        $esner->setPost($this);
        return $this;
    }

    public function removeEsner(Esner $esner)
    {
        $this->esners->removeElement($esner);
    }

    public function getEsners()
    {
        return $this->esners;
    }

    public function __toString(){
        return $this->name;
    }
}