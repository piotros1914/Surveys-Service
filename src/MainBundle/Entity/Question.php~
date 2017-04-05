<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class Question {
	
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id()
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	/**
	 * @ORM\Column(name="type", type="string", length=100)
	 */
	private $type;
	/**
	 * @ORM\Column(name="questionText", type="text")
	 */
	private $questionText;
	/**
	 * @ORM\Column(name="position", type="integer")
	 */
	private $position;
	
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="surveyId", type="integer")
	 */
	private $surveyId;
	
	private $options;
	
	public function __construct()
	{
		$this->options = new ArrayCollection();
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
     * Set type
     *
     * @param string $type
     *
     * @return Question
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set questionText
     *
     * @param string $questionText
     *
     * @return Question
     */
    public function setQuestionText($questionText)
    {
        $this->questionText = $questionText;

        return $this;
    }

    /**
     * Get questionText
     *
     * @return string
     */
    public function getQuestionText()
    {
        return $this->questionText;
    }

    /**
     * Set surveyId
     *
     * @param integer $surveyId
     *
     * @return Question
     */
    public function setSurveyId($surveyId)
    {
        $this->surveyId = $surveyId;

        return $this;
    }

    /**
     * Get surveyId
     *
     * @return integer
     */
    public function getSurveyId()
    {
        return $this->surveyId;
    }
    
	public function getOptions() {
		if(is_null($this->options))
			$this->options = new ArrayCollection();
		
			return $this->options;
	}
	
	public function setOptions($options) {
		$this->options = $options;
		return $this;
	}
	

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Question
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}
