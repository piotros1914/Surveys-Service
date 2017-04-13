<?php

namespace MainBundle\Model;

use MainBundle\Entity\Question;
use MainBundle\Entity\Survey;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use MainBundle\Model\QuestionBuilder;

class SurveyBuilder {

	protected $form;

	protected $em;
	
	protected $survey;
	
	protected $surveyId;
	
	public function __construct($survey, $form) {
		$this->form = $form;
		$this->survey = $survey;
	}
		
	public function createSurveyForm(){
			
		$this->createAllQuestions();
		$this->form->add ( 'submit', SubmitType::class, array (
				'label' => "Prześlij",
				'attr' => array (
						'class' => 'btn btn-primary'
				)
		) );
	
		$surveyFromView = $this->form->getForm();	
		return $surveyFromView->createView();
	}
	
	public function createSurveyWithoutSubmitButton(){	
		
		$this->createAllQuestions();
	
		$surveyFromView = $this->form->getForm();
		return $surveyFromView->createView();
	}
	
	private function createAllQuestions(){
	
 		$questions = $this->survey->getQuestions();		
		$questionBuilder = new QuestionBuilder( $this->form);	
		foreach ( $questions as $question ) {
			$this->form = $questionBuilder->buildQuestion ( $question );
		}	
	}
	
	public function  setFormAction($url){
		
		$this->form->setAction ($url);	
	}
	
	public function  getSurvey(){
		
		return $this->survey;
	}
	


}