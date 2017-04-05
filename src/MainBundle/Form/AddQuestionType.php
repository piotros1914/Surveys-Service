<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class AddQuestionType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('question', QuestionType::class, array(
				'label' => false
		));
		
		$builder->add('addNextQuestion', SubmitType::class, array(
				'label' =>'Dodaj kolejne pytanie',
				'attr' => array(
						'class' => 'btn btn-default'
				)
		));
		
		$builder->add('endCreateSurvey', SubmitType::class, array(
				'label' =>'Zakończ tworzenie ankiety',
				'attr' => array(
						'class' => 'btn btn-success'
				)
		));
	}
	
	public function getName()
	{
		return 'addQuestion';
	}
}