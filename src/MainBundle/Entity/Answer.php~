<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="answers")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\AnswerRepository")
 */
class Answer {
	
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id()
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\Column(name="answerText", type="text")
	 */
	private $answerText;
	
	
	/**
	 * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers", cascade={"persist"})
	 * @ORM\JoinColumn(name="question", referencedColumnName="id")
	 */
	private $question;

	
  

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
     * Set answerText
     *
     * @param string $answerText
     *
     * @return Answer
     */
    public function setAnswerText($answerText)
    {
        $this->answerText = $answerText;

        return $this;
    }

    /**
     * Get answerText
     *
     * @return string
     */
    public function getAnswerText()
    {
        return $this->answerText;
    }

    /**
     * Set question
     *
     * @param \MainBundle\Entity\Question $question
     *
     * @return Answer
     */
    public function setQuestion(\MainBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \MainBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
