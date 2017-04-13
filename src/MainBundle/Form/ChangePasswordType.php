<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class ChangePasswordType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add ( 'oldPassword', PasswordType::class, array (
				'label' => 'Stare hasło' 
		) );
		
		$builder->add ( 'newPassword', RepeatedType::class, array (
				'first_options' => array (
						'label' => 'Nowe hasło' 
				),
				'second_options' => array (
						'label' => 'Powtórz hasło' 
				),
				'type' => PasswordType::class 
		) );
		
		$builder->add ( 'save', SubmitType::class, array (
				'label' => 'Zapisz nowe hasło',
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