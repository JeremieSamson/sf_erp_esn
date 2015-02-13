<?php

namespace ESN\PermanenceBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * PermanenceReport
 *
 * @ORM\Table()
 * @ORM\Entity
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
}
