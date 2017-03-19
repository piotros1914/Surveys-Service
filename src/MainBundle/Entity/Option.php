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
	 * @var integer
	 *
	 * @ORM\Column(name="questionId", type="integer")
	 */
	private $questionId;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="surveyId", type="integer")
	 */
	private $surveyId;
	


    

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
     * Set optionText
     *
     * @param string $optionText
     *
     * @return Option
     */
    public function setOptionText($optionText)
    {
        $this->optionText = $optionText;

        return $this;
    }

    /**
     * Get optionText
     *
     * @return string
     */
    public function getOptionText()
    {
        return $this->optionText;
    }

    /**
     * Set qestionId
     *
     * @param integer $qestionId
     *
     * @return Option
     */
    public function setQestionId($qestionId)
    {
        $this->qestionId = $qestionId;

        return $this;
    }

    /**
     * Get qestionId
     *
     * @return integer
     */
    public function getQestionId()
    {
        return $this->qestionId;
    }

    /**
     * Set surveyId
     *
     * @param integer $surveyId
     *
     * @return Option
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

    /**
     * Set questionId
     *
     * @param integer $questionId
     *
     * @return Option
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * Get questionId
     *
     * @return integer
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }
}
