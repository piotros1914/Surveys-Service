<?php

namespace MainBundle\Form;

use MainBundle\Entity\Question;
use MainBundle\Services\QuestionFactory;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use MainBundle\Entity\Option;

// use Poll\PollBundle\Service\ObjectFactory;
// use Poll\PollBundle\Entity\QuestionImpl;
// use Poll\PollBundle\Query\PollQuery;


class DynamicQuestion {

	protected $form;

	protected $em;
	
	protected $expanded = True;
	
	protected $multiple = True;
	
	protected $label;
	
	protected $formOptions = array();

	public function __construct($form, $em) {
		$this->form = $form;
		$this->em = $em;
	}
	
	public function buildQuestion(Question $question) {
	
		$type = $question->getType();
		$label = $question->getPosition();
		$this->label = $label.". ".$question->getQuestionText();
		
		switch($type) {
			case QuestionFactory::TEXT_QUESTION:
				$this->doTextQuestion($question);
				break;
			case QuestionFactory::SINGLE_CHOICE_QUESTION:
				$this->multiple = False;
				$this->doChoiceQuestion($question);
				break;
			case QuestionFactory::MULTIPLE_CHOICE_QUESTION:
				$this->multiple = True;
				$this->doChoiceQuestion($question);
				break;
			default:
				throw new \Exception("Invalid question type");
		}
		

		return $this->form;
	}
	
	private function doTextQuestion(Question $question) {
		$this->form->add($question->getId(), TextareaType::class, array(
			    'label' => $this->label,
				'label_attr' => array(
						'class' => 'numeration'
				)
		));
	}
	
	private function doChoiceQuestion(Question $question) {
		
		$questionId = $question->getId();			
		$options = $this->em->getRepository('MainBundle:Option')->findBy(array('questionId'=>$questionId));
		$this->doOption( $options );
		$this->form->add($question->getId(), ChoiceType::class, array(
				'choices' => $this->formOptions,
				'label' => $this->label,
				'expanded' =>$this->expanded,
				'multiple' => $this->multiple,
				'label_attr' => array(
						'class' => 'numeration'
				)
		));
		
	}
	private function doOption($options) {
		$this->formOptions = array();
		foreach ($options as $option) {
			array_push($this->formOptions, array($option->getOptionText() => $option->getId()));
		}
	
	}
	
	

}