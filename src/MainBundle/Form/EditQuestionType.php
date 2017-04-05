<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class EditQuestionType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('question', QuestionType::class, array(
				'label' => false
		));
		
		$builder->add('save', SubmitType::class, array(
				'label' =>'Zapisz zmiany'
		
		));
	}
	
	public function getName()
	{
		return 'editQuestion';
	}
}