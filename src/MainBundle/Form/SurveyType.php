<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use MainBundle\Entity\Activity;

class SurveyType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add ( 'title', TextType::class, array (
				'label' => 'Wpisz tytuł ankiety.' 
		) );
		$builder->add ( 'description', TextareaType::class, array (
				'label' => 'Opisz czego dotyczyć będzie ankieta.' 
		) );
		
		$builder->add ( 'activityChoice', ChoiceType::class, array (
				'label' => 'Czy chcesz aby ankieta była aktywna cały czas?',
				'expanded' =>true,
				'choices' => array(
						'Limit odpowiedzi' => 'answerLimit',
						'Ankieta czasowa' => 'endDate',
						'Zawsze aktywna' =>'is_alwaysActive',
						
				),					
				'choice_attr' => array(
						'Limit odpowiedzi'=>['class' =>'activity_select'],
						'Ankieta czasowa' =>['class' =>'activity_select'],
						'Zawsze aktywna' =>['class' =>'activity_select'],
				),
				'preferred_choices' => array('Zawsze aktywna'),
				'data' => 'Zawsze aktywna',
				'mapped' => false
		) );
		
		$builder->add ( 'activity', ActivityType::class, array (
				'label' => false							
		));
		
		$builder->add ( 'visibility', ChoiceType::class, array (
				'label' => 'Czy chcesz aby ankiete widzieli wszyscy?',
				'expanded' =>true,
				'choices' => array(
						'Tak, może ją widzieć każdy na tej stronie' => true,
						'Nie, dostęp tylko za pośrednictwem linka' => false
				),
				'preferred_choices' => array('true')
		) );
		
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults ( array (
				'data_class' => 'MainBundle\Entity\Survey' 
		) );
	}
	
	public function getName() {
		return 'survey';
	}
}