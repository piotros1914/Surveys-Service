<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ForgotPasswordType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add ( 'email', EmailType::class, array (
				'label' => 'Email' 
		) );
		
		$builder->add ( 'send', SubmitType::class, array (
				'label' => 'Wyślij nowe hasło',
				'attr' => array (
						'class' => 'btn btn-success btn-sm' 
				) 
		)
		 );
	}
	public function getName() {
		return 'changePassword';
	}
}