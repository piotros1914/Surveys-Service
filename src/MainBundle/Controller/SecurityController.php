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
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use MainBundle\Form\Model\ChangePassword;
use MainBundle\Form\ChangePasswordType;
use Symfony\Component\BrowserKit\Response;
use MainBundle\Form\Model\ForgotPassword;
use MainBundle\Form\ForgotPasswordType;
use MainBundle\Services\PasswordGenerator;


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
			$em = $this->getDoctrine()->getManager ();
			$em->persist ( $user );
			$em->flush ();
			
			$token = new UsernamePasswordToken ( $user, null, 'main', $user->getRoles () );
			$this->get ( 'security.token_storage' )->setToken ( $token );
			$this->get ( 'session' )->set ( '_security_main', serialize ( $token ) );
			
			return $this->redirectToRoute ( 'registrationDone' );
		}
		
		return array (
				'form' => $form->createView () 
		);
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
	
	/**
	 * @Route("/profil", name="profil")
	 * @Template()
	 */
	public function profilAction(Request $request){	
		
		$changePassword = new ChangePassword();
		$user = $this->container->get ( 'security.token_storage' )->getToken ()->getUser ();
		$form = $this->createForm(ChangePasswordType::class, $changePassword);
		
		$form->handleRequest($request);
		
		if($form->isValid() && $form->isSubmitted()){
			$session = $request->getSession();
					
			$plainPassword = $this->get('security.password_encoder')->encodePassword($user, $changePassword->getNewPassword());
			$user->setPassword($plainPassword);
			$em = $this->getDoctrine()->getManager ();
			$em->persist ( $user );
			$em->flush ();	
			$session->getFlashBag()->add('success', 'Hasło zostało pomyślnie zmienione! Od teraz możesz logować się zapomocą nowych danych');
			
			return $this->redirectToRoute ( 'changePasswordDone' );	
		}
		
		return array(
				'changePasswordForm' => $form->createView (),
		);
	}
	
	/**
	 * @Route("/changePasswordDone", name="changePasswordDone")
	 * @Template()
	 */
	public function changePasswordDoneAction(){
		return array ();
	}

	
	/**
	 * @Route("/forgotPasswor", name="forgotPassword")
	 * @Template()
	 */
	public function forgotPasswordAction(Request $request)
	{
		$forgotPassword = new ForgotPassword();
		$form = $this->createForm(ForgotPasswordType::class, $forgotPassword);
		
		$form->handleRequest($request);
		
		if($form->isValid() && $form->isSubmitted()){
			
			$session = $request->getSession();
			$email = $forgotPassword->getEmail();
			$em = $this->getDoctrine()->getManager();		
			$user = $em->getRepository ( 'MainBundle:User' )->findOneBy(array('email' => $email));
		
			if($user){
				
				$passwordGenerator = new PasswordGenerator();
				$newPassword = $passwordGenerator->generateRandomPassword(6);		
				$password = $this->get('security.password_encoder')->encodePassword($user, $newPassword);
				$user->setPassword($password);
				$em->persist ( $user );
				$em->flush ();
										
				$message = \Swift_Message::newInstance()
				->setSubject('Zmiana hasła')
				->setFrom('kontakt@ankietka.eu')
				->setTo($email)
				->setBody(
						$this->renderView(			
							'MainBundle:Security:Email/newPassword.html.twig',
							array(
								'newPassword' => $newPassword									
							)),
							'text/html'
						);
				$this->get('mailer')->send($message);
				
				$session->getFlashBag()->add('success', 'Hasło zostało pomyślnie zmienione! Nowe hasło zostałe wysłane na podany adres email');
			}
			else 
				$session->getFlashBag()->add('noSuccess', 'Przykro nam, ale nie mamy takiego adresu w bazie. Może wdała się literówka?');
				
		}
		
		return array (
				'forgotPasswordForm' => $form->createView ()
		);
	}
	
	
	/**
	 * @Route("/send", name="send")
	 * @Template()
	 */
	public function sendAction()
	{
		$message = \Swift_Message::newInstance()
		->setSubject('Hello Email')
		->setFrom('kontakt@ankietka.eu')
		->setTo('piotros1914@gmail.com');
		$this->get('mailer')->send($message);
		
		

		return $this->render ( 'MainBundle:Default:index.html.twig', array (
			
		));
	}
	
	
}
