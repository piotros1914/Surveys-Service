<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MainBundle\Form\RegistrationType;
use MainBundle\Form\LoginType;
use MainBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Form\Model\Registration;


class SecurityController extends Controller{
	
	/**
	 * @Route("/login", name="login")
	 */
	public function loginAction(){
		$authenticationUtils = $this->get('security.authentication_utils');
		
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
		
		$user = new User();
		
		$form = $this->createForm(LoginType::class, $user,
					array(  'action' => $this->generateUrl('login')					
				));
	
		
		return $this->render('MainBundle:Security:login.html.twig', array(
				'last_username' => $lastUsername,
				'error'         => $error,
				'form' 			=> $form->createView()
		));
	}
	/**
	 * @Route("/registration", name="registration")
	 * @Template()
	 */
	public function registrationAction(Request $request){
		
		//$user = new User();
		//$form = $this->createForm(RegistrationType::class, $user);
		$registration = new Registration();
		$form = $this->createForm(RegistrationType::class, $registration);
		
		$form->handleRequest($request);
		
		if($form->isValid() && $form->isSubmitted()){	
			$user = $registration->getUser();
			$password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
			$user->setPassword($password);
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			
			return $this->redirectToRoute('registrationDone');
		}
		
		return array ('form' => $form->createView());
	}
	/**
	 * @Route("/registration_succes", name="registrationDone")
	 * @Template()
	 */
	public function registrationDoneAction(Request $request){		
		return array ();
	}

	/**
	 * @Route("/terms", name="terms")
	 * @Template()
	 */
	public function termsAction(){
		
	
		return array();
	}
	
	
}
