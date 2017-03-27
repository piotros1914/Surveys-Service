<?php
namespace MainBundle\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
	protected
	$router,
	$security,
	$doctrine;

	public function __construct(Router $router, AuthorizationChecker $security, Doctrine $doctrine)
	{
		$this->router = $router;
		$this->security = $security;
		$this->doctrine = $doctrine;
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
		$em = $this->doctrine->getManager();
		$repository = $em->getRepository('MainBundle:User');
		$user = $repository->findOneByUsername($token->getUsername());
		
		$user->setLastLogged(new \DateTime());
		$em->persist($user);
		$em->flush();
		
	
		$response = new RedirectResponse($this->router->generate('panel'));

		return $response;
	}
}