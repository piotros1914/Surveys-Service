<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SurveyType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder->add('title', TextType::class, array(
				'label' => 'Tytuł ankiety'
		));
		$builder->add('description', TextareaType::class, array(
				'label' =>'Krótka charakterystyka'
		));
	
		$builder->add('save', SubmitType::class, array(
				'label' =>'Dodaj ankiete'			
		));
	}
	
	public function getName()
	{
		return 'survey';
	}
}