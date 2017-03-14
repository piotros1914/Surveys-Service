<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistrationType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder->add('username', TextType::class, array(
				'label' => 'Użytkownik'
		));
		$builder->add('email', EmailType::class);

		$builder->add('password', RepeatedType::class, array(
				'first_options'  => array('label' => 'Hasło'),
				'second_options' => array('label' => 'Powtórz hasło'),
				'type'        => PasswordType::class
		));
		$builder->add('save', SubmitType::class, array(
				'label' =>'Utwórz konto'
				
		));
	}
	
	public function getName()
	{
		return 'registration';
	}
}