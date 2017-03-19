<?php

namespace MainBundle\Model;

use MainBundle\Services\QuestionFactory;
use MainBundle\Entity\Answer;

class AnswerRecorder {
	
	protected $em;
	protected $answer;
	protected $question;

	public function __construct($em) {
		$this->em = $em;
	}
	
	public function addAnswer($question, $answerContent) {
		$this->question = $question;		
		$this->answer = new Answer();
		
		switch($this->question->getType()) {
			case QuestionFactory::TEXT_QUESTION:
				$this->doSingleAnswer($answerContent);		
				$this->em->persist($this->answer);
				break;
			
			case QuestionFactory::SINGLE_CHOICE_QUESTION:					
				$option = $this->em->getRepository('MainBundle:Option')->find($answerContent);			
				$this->doSingleAnswer($option->getOptionText());
				$this->em->persist($this->answer);
				break;
				
			case QuestionFactory::MULTIPLE_CHOICE_QUESTION:
				$this->doMultiChoiceAnswer($answerContent);
				break;
							
			default:
				throw new \Exception("Invalid question type");				
		}
	
		
	}
	private function doSingleAnswer($answerContent) {		
	 $this->answer->setAnswerText($answerContent);
	 $this->answer->setQuestionId($this->question->getId());
	 $this->answer->setSurveyId($this->question->getSurveyId());
	}


	private function doMultiChoiceAnswer($answerContent) {
		foreach($answerContent as $ans) {
			$this->answer = new Answer();
			$this->answer->setAnswerText($ans);
			$this->answer->setQuestionId($this->question->getId());
			$this->answer->setSurveyId($this->question->getSurveyId());
			$option = $this->em->getRepository('MainBundle:Option')->find($ans);
			$this->answer->setAnswerText($option->getOptionText());
			$this->em->persist($this->answer);
		}
	}
	
	public function save() {
		$this->em->flush();
	}
}