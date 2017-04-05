<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class newSurveyType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('survey', SurveyType::class, array(
				'label' => false
		));
		
		$builder->add('save', SubmitType::class, array(
				'label' =>'Utwórz ankiete',
				'attr' => array(
						'class' =>'btn-success'
				)
		
		));
	}
	
	public function getName()
	{
		return 'newSurvey';
	}
}