<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MainBundle\Form\DynamicQuestion;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use MainBundle\Model\SurveyBuilder;

class DefaultController extends Controller {
	/**
	 * @Route("/", name="home")
	 * @Template()
	 */
	public function indexAction() {
		return array ();
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
		
		
		$em = $this->getDoctrine()->getManager();
		$form = $this->createFormBuilder();
		
		$surveyBuilder = new SurveyBuilder($surveyId, $em, $form);
		$surveyBuilder->setFormAction(
					$this->generateUrl ( 'answer', array (
							'surveyId' => $surveyId					
				) ));
		
		return array(
				'survey' => $surveyBuilder->getSurvey(),
				'form' => $surveyBuilder->createSurveyForm()
		);
		
		
		
// 		$repository = $this->getDoctrine()->getRepository('MainBundle:Question');
		
// 		$query = $repository->createQueryBuilder('p')
// 		->where('p.surveyId = :surveyId')
// 		->orderBy('p.position', 'ASC')
// 		->setParameter('surveyId', $surveyId)
// 		->getQuery();
		
// 		$questions = $query->getResult();
		
// 		$survey = $this->getDoctrine ()->getRepository ( 'MainBundle:Survey' )->find ( $surveyId );
		
// 		$form = $this->createFormBuilder ();
// 		$em = $this->getDoctrine ()->getManager ();
		
// 		$dq = new DynamicQuestion ( $form, $em );
		
// 		foreach ( $questions as $question ) {
// 			$form = $dq->buildQuestion ( $question );
// 		}
		
// 		$form->setAction ( $this->generateUrl ( 'answer', array (
// 				'surveyId' => $surveyId 
// 		) ) );
// 		$form->add ( 'submit', SubmitType::class, array (
// 				'label' => "Prześlij",
// 				'attr' => array (
// 						'class' => 'btn btn-primary' 
// 				) 
// 		) );
		
// 		$form = $form->getForm ();
// 		return array (
// 				'survey' => $survey,
// 				'form' => $form->createView () 
// 		);
	}
	
	/**
	 * @Route("/surveys/{page}", name="surveys")
	 * @Template()
	 */
	public function surveysAction($page = 1) {	
				
		$max = 20;
		$offset = ($page * $max) - $max;
		$repository = $this->getDoctrine()->getRepository('MainBundle:Survey');
		$surveys = $repository->findAllVisibleAndActiveSurveys($max, $offset);
		$surveysNumber = $repository->numberAllVisibleAndActiveSurveys();
		$pagesQuantity = ceil($surveysNumber/$max);
		
		return array (
				'surveys' => $surveys,
				'page' => $page,
				'pagesQuantity' => $pagesQuantity
				
		);
	}
	
	/**
	 * @Route("/newResults/{page}", name="newResults")
	 * @Template()
	 */
	public function resultsAction($page = 1) {
		$max = 20;
		$offset = ($page * $max) - $max;
		$repository = $this->getDoctrine()->getRepository('MainBundle:Survey');
	
		$query = $repository->createQueryBuilder('p')
		->where('p.visibility = :visibility')
		->orderBy('p.addedDate', 'DESC')
		->setParameter('visibility', true)
		->setFirstResult($offset)
		->setMaxResults($max)
		->getQuery();
	
		$surveys = $query->getResult();
	
		$allSurveys = $this->getDoctrine ()->getRepository ( 'MainBundle:Survey' )->findAll();
		$surveysNumber = count ($allSurveys);
		$pagesQuantity = ceil($surveysNumber/$max);
	
		return array (
				'surveys' => $surveys,
				'page' => $page,
				'pagesQuantity' => $pagesQuantity
	
		);
	}
	
	
}
