<?php

namespace MainBundle\Model;

use MainBundle\Entity\Question;
use MainBundle\Entity\Survey;
use MainBundle\Form\DynamicQuestion;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


// use Poll\PollBundle\Service\ObjectFactory;
// use Poll\PollBundle\Entity\QuestionImpl;
// use Poll\PollBundle\Query\PollQuery;


class SurveyBuilder {

	protected $form;

	protected $em;
	
	protected $survey;
	


	public function __construct($surveyId, $em, $form) {
		$this->em = $em;
		$this->form = $form;
		$this->survey = $this->em->getRepository('MainBundle:Survey')->find($surveyId);

	}
		
	public function createSurveyEditForm(){			
		$this->createAllQuestions();
		
		$surveyFromView = $this->form->getForm();
		return $surveyFromView->createView();		
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
	
	
	private function createAllQuestions(){
		$questionRepository = $this->em->getRepository('MainBundle:Question');
		
		
		$query = $questionRepository->createQueryBuilder('p')
		->where('p.surveyId = :surveyId')
		->orderBy('p.position', 'ASC')
		->setParameter('surveyId', $this->survey->getId())
		->getQuery();
			
		$questions = $query->getResult ();
		
		$dq = new DynamicQuestion ( $this->form, $this->em );
		
		foreach ( $questions as $question ) {
			$this->form = $dq->buildQuestion ( $question );
		}
	
	}
	
	public function  setFormAction($url){
		$this->form->setAction ($url);
	
	}
	
	public function  getSurvey(){
		return $this->survey;
	}
	
	
	
	
	

}