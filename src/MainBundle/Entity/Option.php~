<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="options")
 * @ORM\Entity
 */
class Option {
	
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id()
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\Column(name="optionText", type="text")
	 */
	private $optionText;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Question", inversedBy="options", cascade={"persist"})
	 * @ORM\JoinColumn(name="question", referencedColumnName="id")
	 */
	private $question;
	
	private $answerNumber;
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set optionText
	 *
	 * @param string $optionText        	
	 *
	 * @return Option
	 */
	public function setOptionText($optionText) {
		$this->optionText = $optionText;
		
		return $this;
	}
	
	/**
	 * Get optionText
	 *
	 * @return string
	 */
	public function getOptionText() {
		return $this->optionText;
	}
	public function answerNumberIncrease() {
		if (is_null ( $this->answerNumber ))
			$this->answerNumber = 0;
		
		$this->answerNumber = $this->answerNumber + 1;
	}
	public function getAnswerNumber() {
		if (is_null ( $this->answerNumber ))
			return 0;
		else
			return $this->answerNumber;
	}
	public function setAnswerNumber($answerNumber) {
		$this->answerNumber = $answerNumber;
		return $this;
	}
	
	/**
	 * Set question
	 *
	 * @param \MainBundle\Entity\Question $question        	
	 *
	 * @return Option
	 */
	public function setQuestion(\MainBundle\Entity\Question $question = null) {
		$this->question = $question;
		
		return $this;
	}
	
	/**
	 * Get question
	 *
	 * @return \MainBundle\Entity\Question
	 */
	public function getQuestion() {
		return $this->question;
	}
}
