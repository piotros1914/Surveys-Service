<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder
			->setAction($options["action"])
			->setMethod('POST')
			->add('username', TextType::class, array(
					'label' =>'Użytkownik',
						
			))
			->add('password', PasswordType::class, array(
					'label' => 'Hasło',
						
			))
			->add('login', SubmitType::class, array(
					'label'	=> 'Zaloguj się'
			));
	}
	
	public function getName()
	{
		return 'registration';
	}
}

