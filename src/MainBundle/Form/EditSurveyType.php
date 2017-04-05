<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class EditSurveyType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('survey', SurveyType::class, array(
				'label' => false
		));
		
		$builder->add('save', SubmitType::class, array(
				'label' =>'Zapisz zmiany'
		
		));
	}
	
	public function getName()
	{
		return 'editSurvey';
	}
}