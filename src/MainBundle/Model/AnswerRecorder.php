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
		
		
		switch ($this->question->getType ()) {
			case QuestionFactory::TEXT_QUESTION :
				$this->doSingleAnswer ( $answerContent );
				break;
			
			case QuestionFactory::SINGLE_CHOICE_QUESTION :
				$option = $this->em->getRepository ( 'MainBundle:Option' )->find ( $answerContent );
				$this->doSingleAnswer ( $option->getOptionText () );
				$this->doSingleAnswer ( $answerContent );
				break;
			
			case QuestionFactory::MULTIPLE_CHOICE_QUESTION :
				$this->doMultiChoiceAnswer ( $answerContent );
				break;
			
			default :
				throw new \Exception ( "Invalid question type" );
		}
	}
	private function doSingleAnswer($answerContent) {
		$answer = new Answer ();
		$answer->setAnswerText ( $answerContent );
		$answer->setQuestion ( $this->question );
		$this->em->persist ( $answer );
	}
	private function doMultiChoiceAnswer($answerContent) {
		foreach ( $answerContent as $ans ) {
			$answer = new Answer ();
			$answer->setAnswerText ( $ans );
			$answer->setQuestion ( $this->question);		
			$option = $this->em->getRepository ( 'MainBundle:Option' )->find ( $ans );
			$answer->setAnswerText ( $option->getOptionText () );
			$this->em->persist ( $answer );
		}
	}
	public function flushAllAnswer() {
		$this->em->flush ();
	}
}