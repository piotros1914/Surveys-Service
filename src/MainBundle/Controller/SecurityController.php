<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MainBundle\Form\RegistrationType;
use MainBundle\Form\LoginType;
use MainBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;


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
		
		$user = new User();
		$form = $this->createForm(RegistrationType::class, $user);
		
		$form->handleRequest($request);
		
		if($form->isValid() && $form->isSubmitted()){					
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			
			return $this->redirectToRoute('home');
		}
		
		return array ('form' => $form->createView());
	}
	/**
	 * @Route("/registration_succes", name="registration_done")
	 * @Template()
	 */
	public function registrationDoneAction(Request $request){
		
	return array ();
	}
}
