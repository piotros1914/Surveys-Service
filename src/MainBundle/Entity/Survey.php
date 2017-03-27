<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Survey
 *
 * @ORM\Table(name="survey")
 * @ORM\Entity
 */
class Survey
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="responesNumber", type="integer", nullable=true)
     */
    private $responesNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addedDate", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $addedDate;


    public function __construct(){   	
    	$this->addedDate = new \DateTime();

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
     * Set title
     *
     * @param string $title
     *
     * @return Survey
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Survey
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Survey
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    public function setEmpty(){
    	$this->description = ' Nowa ankieta  ';
    	$this->title = ' Nowa ankieta ';
    	$this->userId = '  User';
    }
    

    /**
     * Set addedDate
     *
     * @param \DateTime $addedDate
     *
     * @return Survey
     */
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    /**
     * Get addedDate
     *
     * @return \DateTime
     */
    public function getAddedDate()
    {
        return $this->addedDate;
    }

    /**
     * Set responesNumber
     *
     * @param integer $responesNumber
     *
     * @return Survey
     */
    public function setResponesNumber($responesNumber)
    {
        $this->responesNumber = $responesNumber;

        return $this;
    }

    /**
     * Get responesNumber
     *
     * @return integer
     */
    public function getResponesNumber()
    {
        return $this->responesNumber;
    }
}
