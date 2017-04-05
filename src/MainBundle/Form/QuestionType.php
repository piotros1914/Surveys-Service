<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use MainBundle\Services\QuestionFactory;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use MainBundle\Entity\Question;

class QuestionType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		
		$builder->add('type', ChoiceType::class, array(
				'choices'  => array(
						'Tekst' => QuestionFactory::TEXT_QUESTION,
						'Pojedynczy wybór' => QuestionFactory::SINGLE_CHOICE_QUESTION,		
						'Wielokrotny wybór' => QuestionFactory::MULTIPLE_CHOICE_QUESTION
				),
				'label' =>'Rodzaj pytania'
		));
		$builder->add('questionText', TextareaType::class, array(
				'label' => 'Pytanie'
		));
		
		$builder->add('options', CollectionType::class, array(
				'entry_type' => OptionType::class,
				'allow_add'    => true,
				'allow_delete' => true,
				'by_reference' => false,
				'prototype' => true,
				'label' => false
		));
	
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => Question::class,
		));
	}
	
	
	public function getName()
	{
		return 'survey';
	}
}