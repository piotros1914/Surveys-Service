<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use MainBundle\Entity\Activity;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ActivityType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add ( 'endDate', DateTimeType::class, array (
				'label' => 'Data zakończenia',
				'required' => false,
				'widget' => 'single_text',
				'format' => 'yyyy-MM-dd',
				'attr' => array (
						'class' => 'activity',
						'placeholder' => 'Kliknij i wybiesz datę zakończenia'
				) 
		)
		 );
		
		$builder->add ( 'answerLimit', TextType::class, array (
				'label' => 'Limit osób biorących udział',
				'required' => false,
				'attr' => array (
						'class' => 'activity',
						'placeholder' => 'Podaj wartość liczbową'
				) 
			
		)
		 );
		
		$builder->add ( 'is_alwaysActive', HiddenType::class, array () );
	}
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults ( array (
				'data_class' => Activity::class 
		) );
	}
	public function getName() {
		return 'activity';
	}
}