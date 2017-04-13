<?php
namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
				
		$builder->add('email', EmailType::class);

		$builder->add('plainPassword', RepeatedType::class, array(
				'first_options'  => array('label' => 'Hasło'),
				'second_options' => array('label' => 'Powtórz hasło'),
				'type'        => PasswordType::class
		));	
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}