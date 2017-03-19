<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder->add('questionText', TextType::class, array(
				'label' => 'Pytanie'
		));
		$builder->add('type', ChoiceType::class, array(
				'choices'  => array(
						'Maybe' => null,
						'Yes' => true,
						'No' => false,
				),
		));
	
		$builder->add('save', SubmitType::class, array(
				'label' =>'Dodaj'			
		));
	}
	
	public function getName()
	{
		return 'survey';
	}
}