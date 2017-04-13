<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MainBundle\Services\PaginationWidget;

class WidgetsController extends Controller {
	
	/**
	 * @Template()
	 */
	public function lastSurveysWidgetAction($max = 3) {
		$repository = $this->getDoctrine ()->getRepository ( 'MainBundle:Survey' );
		$surveys = $repository->findLastSurveys ( $max );
		
		return array (
				'surveys' => $surveys 
		);
	}
	
	/**
	 * @Template()
	 */
	public function popularSurveysWidgetAction($max = 3) {
		$repository = $this->getDoctrine ()->getRepository ( 'MainBundle:Survey' );
		$surveys = $repository->findPopularSurveys ( $max );
		
		return array (
				'surveys' => $surveys 
		);
	}
	
	/**
	 * @Template()
	 */
	public function allActiveSurveysWidgetAction() {
		$repository = $this->getDoctrine ()->getRepository ( 'MainBundle:Survey' );
		$surveysNumber = $repository->numberAllVisibleAndActiveSurveys ();
		
		return array (
				'surveysNumber' => $surveysNumber 
		);
	}
	/**
	 * @Template()
	 */
	public function allResultsWidgetAction() {
		$repository = $this->getDoctrine ()->getRepository ( 'MainBundle:Survey' );
		$surveysNumber = $repository->numberAllVisibleAndCompletedSurveys ();
		
		return array (
				'surveysNumber' => $surveysNumber 
		);
	}
	
	/**
	 * @Template()
	 */
	public function userNumberWidgetAction() {
		$users = $this->getDoctrine ()->getRepository ( 'MainBundle:User' )->findAll();
		$surveysNumber = count($users);
	
		return array (
				'usersNumber' => $surveysNumber
		);
	}
	
	/**
	 * @Template()
	 */
	public function visitCounterWidgetAction() {
		$em = $this->getDoctrine ()->getManager ();
		$visitCounter = $em->getRepository ( 'MainBundle:VisitCounter' )->findOneBy ( array (), array ('id' => 'DESC') );
		$usersNumber = $visitCounter->getVisits();
	
		return array (
				'usersNumber' => $usersNumber
		);
	}
	
	
	
	/**
	 * @Template()
	 */
	public function paginationWidgetAction($actualPage, $numberOfPages) {
		$pagination = new PaginationWidget ( $actualPage, $numberOfPages );
		return array (
				'pagination' => $pagination 
		);
	}
}
