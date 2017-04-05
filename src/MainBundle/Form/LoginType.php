<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class LoginType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder
			->setAction($options["action"])
			->setMethod('POST')
			->add('email', TextType::class, array(
					'label' =>'Email',
					'constraints' => new NotBlankValidator(),
					'attr' => array(
							'placeholder' => 'Email'
					)
					
						
			))
			->add('password', PasswordType::class, array(
					'label' => 'Hasło',		
					'constraints' => new NotBlankValidator(),
					'attr' => array(
							'placeholder' => 'Twoje hasło'
					)
						
			))			
			->add('login', SubmitType::class, array(
					'label'	=> 'Zaloguj się',
					'attr' => array(
							'class' => 'btn btn-success btn-sm'
					)
			));
	}
	
	public function getName()
	{
		return 'registration';
	}
}

