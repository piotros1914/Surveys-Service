<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use MainBundle\Entity\Option;

class OptionType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		
		
		$builder->add('optionText', TextType::class, array(
				'label' => 'Opcja',
				'required' => false,
		));
	
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => Option::class,
		));
	}
	
	
	public function getName()
	{
		return 'option';
	}
}