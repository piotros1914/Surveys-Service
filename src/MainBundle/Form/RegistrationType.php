<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class RegistrationType extends AbstractType{
	
// 	public function buildForm(FormBuilderInterface $builder, array $options){
		

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('user', UserType::class, array(
				'label' => false
		));
		$builder->add('terms', CheckboxType::class, array(
				'mapped' => false,
				'label' => 'Regulamin',
			
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