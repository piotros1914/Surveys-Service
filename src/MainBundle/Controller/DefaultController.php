<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MainBundle\Model\SurveyBuilder;
use MainBundle\Entity\VisitCounter;

class DefaultController extends Controller {
	/**
	 * @Route("/", name="home")
	 * @Template()
	 */
	public function indexAction() {
		$this->changeVisitCounter();
				
		return array ();
	}
	

	private function changeVisitCounter() {
		$em = $this->getDoctrine ()->getManager ();
		$visitCounter = $em->getRepository ( 'MainBundle:VisitCounter' )->findOneBy ( array (), array (
				'id' => 'DESC' 
		) );
		
		if (! $visitCounter) {
			$visitCounter = new VisitCounter ();
			$em->persist ( $visitCounter );
			$em->flush ();
			return;
		} 
		
		$date = new \DateTime ();
		$lastDate = $visitCounter->getDate ();
		$lastDateStr = $lastDate->format ( 'Y-m-d' );
		$dateStr = $date->format ( 'Y-m-d' );
		
		if ($dateStr != $lastDateStr)
			$visitCounter = new VisitCounter ();
		else {
			$visitsNumber = $visitCounter->getVisits ();
			$visitsNumber = $visitsNumber + 1;
			$visitCounter->setVisits ( $visitsNumber );
		}
		
		$em->persist ( $visitCounter );
		$em->flush ();
	}

	
	/**
	 * @Route("/about", name="about")
	 * @Template()
	 */
	public function aboutAction() {
		return array ();
	}
	
	/**
	 * @Route("/survey/{surveyId}", name="survey")
	 * @Template()
	 */
	public function surveyAction($surveyId) {
		$em = $this->getDoctrine ()->getManager ();
		$survey = $em->getRepository ( 'MainBundle:Survey' )->find ( $surveyId );
		
		if (! $survey)
			throw $this->createNotFoundException ( 'Wskazany zasób nie istnieje' );
		
		$form = $this->createFormBuilder ();
		$surveyBuilder = new SurveyBuilder ( $survey, $form );
		$surveyBuilder->setFormAction ( $this->generateUrl ( 'answer', array (
				'surveyId' => $surveyId 
		) ) );
		return array (
				'survey' => $surveyBuilder->getSurvey (),
				'form' => $surveyBuilder->createSurveyForm () 
		);
	}
	
	/**
	 * @Route("/thanks/{surveyId}", name="thanks")
	 * @Template()
	 */
	public function thanksAction($surveyId) {
		$em = $this->getDoctrine ()->getManager ();
		$survey = $em->getRepository ( 'MainBundle:Survey' )->find ( $surveyId );
		
		if (! $survey)
			throw $this->createNotFoundException ( 'Wskazany zasób nie istnieje' );
		
		
		return array (
				'survey' => $survey,
		);
	}
	
	
	/**
	 * @Route("/result/{surveyId}", name="result")
	 * @Template()
	 */
	public function resultAction($surveyId) {
		$em = $this->getDoctrine ()->getManager ();
		$survey = $em->getRepository ( 'MainBundle:Survey' )->find ($surveyId );
		$questions = $survey->getQuestions();
		
		return array (
				'questions' => $questions,
				'survey' => $survey
		);
	}
	
	
	
	/**
	 * @Route("/surveys/{page}", name="surveys")
	 * @Template()
	 */
	public function surveysAction($page = 1) {
		$surveysOnSite = 20;
		$offset = ($page * $surveysOnSite) - $surveysOnSite;
		$repository = $this->getDoctrine ()->getRepository ( 'MainBundle:Survey' );
		$surveys = $repository->findAllVisibleAndActiveSurveys ( $surveysOnSite, $offset );
		$surveysNumber = $repository->numberAllVisibleAndActiveSurveys ();
		$numberOfPages = ceil ( $surveysNumber / $surveysOnSite );
		
		return array (
				'surveys' => $surveys,
				'actualPage' => $page,
				'numberOfPages' => $numberOfPages 
		);
	}
	
	/**
	 * @Route("/surveysResultsA/{page}", name="surveysResults")
	 * @Template()
	 */
	public function surveysResultsAction($page = 1) {
		$surveysOnSite = 20;
		$offset = ($page * $surveysOnSite) - $surveysOnSite;
		$repository = $this->getDoctrine ()->getRepository ( 'MainBundle:Survey' );
		$surveys = $repository->findAllVisibleAndCompletedSurveys ( $surveysOnSite, $offset );
		$surveysNumber = $repository->numberAllVisibleAndActiveSurveys ();
		$numberOfPages = ceil ( $surveysNumber / $surveysOnSite );
		
		return array (
				'surveys' => $surveys,
				'actualPage' => $page,
				'numberOfPages' => $numberOfPages 
		);
	}
	
	/**
	 * @Template()
	 */
	public function servicesAction() {
		return array ();
	}
	
}
