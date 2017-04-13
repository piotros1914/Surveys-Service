<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="questions")
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
	 * @ORM\ManyToOne(targetEntity="Survey", inversedBy="questions", cascade={"persist"})
	 * @ORM\JoinColumn(name="survey", referencedColumnName="id")
	 */
	private $survey;
	
	/**
	 * @ORM\OneToMany(targetEntity="Option", mappedBy="question", orphanRemoval=true)
	 */
	private $options;
	
	/**
	 * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", orphanRemoval=true)
	 */
	private $answers;
	public function __construct() {
		$this->options = new ArrayCollection ();
		$this->answers = new ArrayCollection ();
	}
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set type
	 *
	 * @param string $type        	
	 *
	 * @return Question
	 */
	public function setType($type) {
		$this->type = $type;
		
		return $this;
	}
	
	/**
	 * Get type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * Set questionText
	 *
	 * @param string $questionText        	
	 *
	 * @return Question
	 */
	public function setQuestionText($questionText) {
		$this->questionText = $questionText;
		
		return $this;
	}
	
	/**
	 * Get questionText
	 *
	 * @return string
	 */
	public function getQuestionText() {
		return $this->questionText;
	}
	public function getOptions() {
		if (is_null ( $this->options ))
			$this->options = new ArrayCollection ();
		
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
	public function setPosition($position) {
		$this->position = $position;
		
		return $this;
	}
	
	/**
	 * Get position
	 *
	 * @return integer
	 */
	public function getPosition() {
		return $this->position;
	}
	
	/**
	 * Set survey
	 *
	 * @param \MainBundle\Entity\Survey $survey        	
	 *
	 * @return Question
	 */
	public function setSurvey(\MainBundle\Entity\Survey $survey = null) {
		$this->survey = $survey;
		
		return $this;
	}
	
	/**
	 * Get survey
	 *
	 * @return \MainBundle\Entity\Survey
	 */
	public function getSurvey() {
		return $this->survey;
	}
	
	/**
	 * Add option
	 *
	 * @param \MainBundle\Entity\Option $option        	
	 *
	 * @return Question
	 */
	public function addOption(\MainBundle\Entity\Option $option) {
		$this->options [] = $option;
		
		return $this;
	}
	
	/**
	 * Remove option
	 *
	 * @param \MainBundle\Entity\Option $option        	
	 */
	public function removeOption(\MainBundle\Entity\Option $option) {
		$this->options->removeElement ( $option );
	}
	
	/**
	 * Add answer
	 *
	 * @param \MainBundle\Entity\Answer $answer        	
	 *
	 * @return Question
	 */
	public function addAnswer(\MainBundle\Entity\Answer $answer) {
		$this->answers [] = $answer;
		
		return $this;
	}
	
	/**
	 * Remove answer
	 *
	 * @param \MainBundle\Entity\Answer $answer        	
	 */
	public function removeAnswer(\MainBundle\Entity\Answer $answer) {
		$this->answers->removeElement ( $answer );
	}
	
	/**
	 * Get answers
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getAnswers() {
		return $this->answers;
	}
}
