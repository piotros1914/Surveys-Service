<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Survey
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity
 */
class Activity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
 
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime", nullable=true)
     */
    private $endDate;
    
    /**
     *
     * @ORM\Column(name="answerLimit", type="integer", nullable=true)
     */
    private $answerLimit;
    
    /**
     *
     * @ORM\Column(name="is_alwaysActive", type="boolean", nullable=true)
     */
    private $is_alwaysActive;
    

    public function __construct(){   	
    	
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
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Activity
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set answerLimit
     *
     * @param integer $answerLimit
     *
     * @return Activity
     */
    public function setAnswerLimit($answerLimit)
    {
        $this->answerLimit = $answerLimit;

        return $this;
    }

    /**
     * Get answerLimit
     *
     * @return integer
     */
    public function getAnswerLimit()
    {
        return $this->answerLimit;
    }

    /**
     * Set isAlwaysActive
     *
     * @param boolean $isAlwaysActive
     *
     * @return Activity
     */
    public function setIsAlwaysActive($isAlwaysActive)
    {
        $this->is_alwaysActive = $isAlwaysActive;

        return $this;
    }

    /**
     * Get isAlwaysActive
     *
     * @return boolean
     */
    public function getIsAlwaysActive()
    {
        return $this->is_alwaysActive;
    }
    
    
}
