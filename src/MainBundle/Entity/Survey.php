<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Survey
 *
 * @ORM\Table(name="surveys")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\SurveyRepository")
 */
class Survey {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer")
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 *
	 * @var string @ORM\Column(name="title", type="string", length=100)
	 */
	private $title;
	
	/**
	 *
	 * @var string @ORM\Column(name="description", type="text")
	 */
	private $description;
	
	/**
	 *
	 * @var integer @ORM\Column(name="responesNumber", type="integer")
	 */
	private $responesNumber;
	
	/**
	 *
	 * @var \DateTime @ORM\Column(name="addedDate", type="datetime")
	 */
	private $addedDate;
	
	/**
	 * @ORM\Column(name="visibility", type="boolean")
	 */
	private $visibility;
	
	/**
	 * @ORM\OneToOne(targetEntity="Activity" , cascade={"persist"})
	 * @ORM\JoinColumn(name="activity_id", referencedColumnName="id")
	 */
	private $activity;
	
	/**
	 * @ORM\OneToMany(targetEntity="Question", mappedBy="survey", orphanRemoval=true)
	 * @ORM\OrderBy({"position" = "ASC"})
	 */
	private $questions;
	
	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="surveys", cascade={"persist"})
	 * @ORM\JoinColumn(name="user_ID", referencedColumnName="id")
	 */
	private $user;
	public function __construct() {
		$this->addedDate = new \DateTime ();
		$this->responesNumber = 0;
		$this->questions = new ArrayCollection ();
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
	 * Set title
	 *
	 * @param string $title        	
	 *
	 * @return Survey
	 */
	public function setTitle($title) {
		$this->title = $title;
		
		return $this;
	}
	
	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Set description
	 *
	 * @param string $description        	
	 *
	 * @return Survey
	 */
	public function setDescription($description) {
		$this->description = $description;
		
		return $this;
	}
	
	/**
	 * Get description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	
	/**
	 * Set addedDate
	 *
	 * @param \DateTime $addedDate        	
	 *
	 * @return Survey
	 */
	public function setAddedDate($addedDate) {
		$this->addedDate = $addedDate;
		
		return $this;
	}
	
	/**
	 * Get addedDate
	 *
	 * @return \DateTime
	 */
	public function getAddedDate() {
		return $this->addedDate;
	}
	
	/**
	 * Set responesNumber
	 *
	 * @param integer $responesNumber        	
	 *
	 * @return Survey
	 */
	public function setResponesNumber($responesNumber) {
		$this->responesNumber = $responesNumber;
		
		return $this;
	}
	
	/**
	 * Get responesNumber
	 *
	 * @return integer
	 */
	public function getResponesNumber() {
		return $this->responesNumber;
	}
	
	public function increaseAnswersNumber($count = 1) {
		$this->responesNumber = $this->responesNumber + $count;
	}
	
	/**
	 * Set visibility
	 *
	 * @param \bool $visibility        	
	 *
	 * @return Survey
	 */
	public function setVisibility($visibility) {
		$this->visibility = $visibility;
		
		return $this;
	}
	
	/**
	 * Get visibility
	 *
	 * @return \bool
	 */
	public function getVisibility() {
		return $this->visibility;
	}
	
	/**
	 * Set activity
	 *
	 * @param \MainBundle\Entity\Activity $activity        	
	 *
	 * @return Survey
	 */
	public function setActivity(\MainBundle\Entity\Activity $activity = null) {
		$this->activity = $activity;
		
		return $this;
	}
	
	/**
	 * Get activity
	 *
	 * @return \MainBundle\Entity\Activity
	 */
	public function getActivity() {
		return $this->activity;
	}
	
	public function isActive() {
		$isActive = true;
		
		$answerLimit = $this->activity->getAnswerLimit();	
		if( !is_null($answerLimit) && $answerLimit <= $this->responesNumber)
			$isActive = false;
		
		$endDate = $this->activity->getEndDate();
		if(!is_null($endDate) && $endDate < new \DateTime())
			$isActive = false;
		
			$is_alwaysActive = $this->activity->getIsAlwaysActive();
		if(!is_null($is_alwaysActive) && !$is_alwaysActive)
			$isActive = false;
			
		
		return $isActive;
	}
	
	
	
	public function getQuestions() {
		return $this->questions;
	}
	public function setQuestions($questions) {
		$this->questions = $questions;
		return $this;
	}
	public function getQuestionsNumber() {
		return count ( $this->questions );
	}
	public function getNextQuestionPosition() {
		return count ( $this->questions ) + 1;
	}
	
	/**
	 * Add question
	 *
	 * @param \MainBundle\Entity\Question $question        	
	 *
	 * @return Survey
	 */
	public function addQuestion(\MainBundle\Entity\Question $question) {
		$this->questions [] = $question;
		
		return $this;
	}
	
	/**
	 * Remove question
	 *
	 * @param \MainBundle\Entity\Question $question        	
	 */
	public function removeQuestion(\MainBundle\Entity\Question $question) {
		$this->questions->removeElement ( $question );
	}

	/**
	 * Set user
	 *
	 * @param \MainBundle\Entity\User $user        	
	 *
	 * @return Survey
	 */
	public function setUser(\MainBundle\Entity\User $user = null) {
		$this->user = $user;
		
		return $this;
	}
	
	/**
	 * Get user
	 *
	 * @return \MainBundle\Entity\User
	 */
	public function getUser() {
		return $this->user;
	}
}
