<?php

namespace ESN\PermanenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ESN\UserBundle\Entity\User;

/**
 * PermanenceReport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESN\PermanenceBundle\Entity\PermanenceReportRepository")
 */
 class PermanenceReport
{
      /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;



     /**
    * @ORM\Column(type="decimal", scale=2)
    */
    private $amountBefore;

    /**
    * @ORM\Column(type="decimal", scale=2)
    */
    private $amountAfter;

     /**
    * @ORM\Column(type="decimal", scale=2)
    */
    private $amountSell;

    /**
    * @ORM\Column(name="sellCard", type="integer")
    */
    private $sellCard;

    /**
    * @ORM\Column(name="availableCard", type="integer")
    */
    private $availableCard;

    
    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text")
     */    
    private $comments; 
     
   /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="ESN\UserBundle\Entity\User", inversedBy="reports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

     /**
      * @var integer
      *
      * @ORM\Column(name="fivty", type="integer")
      */
     private $fivty;

     /**
      * @var integer
      *
      * @ORM\Column(name="twenty", type="integer")
      */
     private $twenty;

     /**
      * @var integer
      *
      * @ORM\Column(name="ten", type="integer")
      */
     private $ten;

     /**
      * @var integer
      *
      * @ORM\Column(name="five", type="integer")
      */
     private $five;

     /**
      * @var integer
      *
      * @ORM\Column(name="two", type="integer")
      */
     private $two;

     /**
      * @var integer
      *
      * @ORM\Column(name="one", type="integer")
      */
     private $one;

     /**
      * @var integer
      *
      * @ORM\Column(name="fivtycent", type="integer")
      */
     private $fivtycent;

     /**
      * @var integer
      *
      * @ORM\Column(name="twentycent", type="integer")
      */
     private $twentycent;

     /**
      * @var integer
      *
      * @ORM\Column(name="tencent", type="integer")
      */
     private $tencent;


    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set soldCard
     *
     * @param integer $soldCard
     * @return PermanenceReport
     */
    public function setSoldCard($soldCard)
    {
        $this->soldCard = $soldCard;

        return $this;
    }

    /**
     * Get soldCard
     *
     * @return integer 
     */
    public function getSoldCard()
    {
        return $this->soldCard;
    }

    /**
     * Set availableCard
     *
     * @param integer $availableCard
     * @return PermanenceReport
     */
    public function setAvailableCard($availableCard)
    {
        $this->availableCard = $availableCard;

        return $this;
    }

    /**
     * Get availableCard
     *
     * @return integer 
     */
    public function getAvailableCard()
    {
        return $this->availableCard;
    }

    /**
     * Set sellCard
     *
     * @param integer $sellCard
     * @return PermanenceReport
     */
    public function setSellCard($sellCard)
    {
        $this->sellCard = $sellCard;

        return $this;
    }

    /**
     * Get sellCard
     *
     * @return integer 
     */
    public function getSellCard()
    {
        return $this->sellCard;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return PermanenceReport
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return PermanenceReport
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amountSell
     *
     * @param string $amountSell
     * @return PermanenceReport
     */
    public function setAmountSell($amountSell)
    {
        $this->amountSell = $amountSell;

        return $this;
    }

    /**
     * Get amountSell
     *
     * @return string 
     */
    public function getAmountSell()
    {
        return $this->amountSell;
    }

    /**
     * Set amountBefore
     *
     * @param string $amountBefore
     * @return PermanenceReport
     */
    public function setAmountBefore($amountBefore)
    {
        $this->amountBefore = $amountBefore;

        return $this;
    }

    /**
     * Get amountBefore
     *
     * @return string 
     */
    public function getAmountBefore()
    {
        return $this->amountBefore;
    }

    /**
     * Set amountAfter
     *
     * @param string $amountAfter
     * @return PermanenceReport
     */
    public function setAmountAfter($amountAfter)
    {
        $this->amountAfter = $amountAfter;

        return $this;
    }

    /**
     * Get amountAfter
     *
     * @return string 
     */
    public function getAmountAfter()
    {
        return $this->amountAfter;
    }

     /**
      * @return mixed
      */
     public function getOwner()
     {
         return $this->owner;
     }

     /**
      * @param User $owner
      */
     public function setOwner(User $owner)
     {
         $this->owner = $owner;
     }

     /**
      * @return int
      */
     public function getFivty()
     {
         return $this->fivty;
     }

     /**
      * @param int $fivty
      */
     public function setFivty($fivty)
     {
         $this->fivty = $fivty;
     }

     /**
      * @return int
      */
     public function getTwenty()
     {
         return $this->twenty;
     }

     /**
      * @param int $twenty
      */
     public function setTwenty($twenty)
     {
         $this->twenty = $twenty;
     }

     /**
      * @return int
      */
     public function getTen()
     {
         return $this->ten;
     }

     /**
      * @param int $ten
      */
     public function setTen($ten)
     {
         $this->ten = $ten;
     }

     /**
      * @return int
      */
     public function getFive()
     {
         return $this->five;
     }

     /**
      * @param int $five
      */
     public function setFive($five)
     {
         $this->five = $five;
     }

     /**
      * @return int
      */
     public function getTwo()
     {
         return $this->two;
     }

     /**
      * @param int $two
      */
     public function setTwo($two)
     {
         $this->two = $two;
     }

     /**
      * @return int
      */
     public function getOne()
     {
         return $this->one;
     }

     /**
      * @param int $one
      */
     public function setOne($one)
     {
         $this->one = $one;
     }

     /**
      * @return int
      */
     public function getFivtycent()
     {
         return $this->fivtycent;
     }

     /**
      * @param int $fivtycent
      */
     public function setFivtycent($fivtycent)
     {
         $this->fivtycent = $fivtycent;
     }

     /**
      * @return int
      */
     public function getTwentycent()
     {
         return $this->twentycent;
     }

     /**
      * @param int $twentycent
      */
     public function setTwentycent($twentycent)
     {
         $this->twentycent = $twentycent;
     }

     /**
      * @return int
      */
     public function getTencent()
     {
         return $this->tencent;
     }

     /**
      * @param int $tencent
      */
     public function setTencent($tencent)
     {
         $this->tencent = $tencent;
     }
}
