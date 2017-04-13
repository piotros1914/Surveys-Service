<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MainBundle\Entity\Survey;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Model\AnswerRecorder;
use MainBundle\Entity\Question;
use MainBundle\Entity\Option;
use Doctrine\Common\Collections\ArrayCollection;
use MainBundle\Form\EditSurveyType;
use MainBundle\Form\Model\EditSurvey;
use MainBundle\Form\Model\EditQuestion;
use MainBundle\Form\EditQuestionType;
use MainBundle\Form\AddQuestionType;
use MainBundle\Form\newSurveyType;
use MainBundle\Form\Model\newSurvey;
use MainBundle\Form\Model\newQuestion;
use MainBundle\Model\SurveyBuilder;

/**
 * @Route("/panel")
 */
class SurveyController extends Controller {
	
	/**
	 * @Route("/", name="panel")
	 * @Template()
	 */
	public function panelAction() {
		return array ();
	}
	
	/**
	 * @Route("/showAllActiveSurveys", name="showAllActiveSurveys")
	 * @Template()
	 */
	public function showAllActiveSurveysAction() {
		$user = $this->container->get ( 'security.token_storage' )->getToken ()->getUser ();
		
		$em = $this->getDoctrine ()->getManager ();
		$surveys = $em->getRepository ( 'MainBundle:Survey' )->findUserActiveSurveys($user->getId());
		
		return array (
				'surveys' => $surveys 
		);
	}
	
	/**
	 * @Route("/showAllEndedSurveys", name="showAllEndedSurveys")
	 * @Template()
	 */
	public function showAllEndedSurveysAction() {
		$user = $this->container->get ( 'security.token_storage' )->getToken ()->getUser ();	
		
		$em = $this->getDoctrine ()->getManager ();
		$surveys = $em->getRepository ( 'MainBundle:Survey' )->findUserEndedSurveys($user->getId());		
	
		return array (
				'surveys' => $surveys
		);
	}

	
	/**
	 * @Route("/showSurveyToEdit/{surveyId}", name="showSurveyToEdit")
	 * @Template()
	 */
	public function showSurveyToEditAction($surveyId) {
		$em = $this->getDoctrine ()->getManager ();
		$survey = $em->getRepository ( 'MainBundle:Survey' )->find ( $surveyId );
		
		if (! $survey)
			throw $this->createNotFoundException ( 'Wskazany zasób nie istnieje' );
		
		$surveyUser = $survey->getUser ();
		$requestingUser = $this->container->get ( 'security.token_storage' )->getToken ()->getUser ();
		if ($surveyUser != $requestingUser)
			throw $this->createAccessDeniedException ( 'Brak dostępu do zasobu' );
		
		$form = $this->createFormBuilder ();
		$surveyBuilder = new SurveyBuilder ( $survey, $form );
		return array (
				'survey' => $surveyBuilder->getSurvey (),
				'form' => $surveyBuilder->createSurveyWithoutSubmitButton () 
		);
	}
	
	/**
	 * @Route("/answer/{surveyId}", name="answer")
	 */
	public function answerAction(Request $request, $surveyId) {
		$em = $this->getDoctrine ()->getManager ();
		$survey = $em->getRepository ( 'MainBundle:Survey' )->find ( $surveyId );
		if (! $survey)
			throw $this->createNotFoundException ( 'Wskazany zasób nie istnieje' );
				
		if($survey->isActive()){		
			$survey->increaseAnswersNumber ();
			$em->persist ( $survey );
			$em->flush ();
			
			$formData = $request->request->get ( 'form' );		
			$answerRecorder = new AnswerRecorder ( $em );			
			$questions = $survey->getQuestions ();
			
			foreach ( $questions as $question ) {
				$answerRecorder->addAnswer ( $question, $formData [$question->getId ()] );
			}			
			
			$answerRecorder->flushAllAnswer ();	
			
			return $this->redirect ( $this->generateUrl ( 'thanks', array('surveyId' => $surveyId) ) );
		}

		return $this->redirect ( $this->generateUrl ( 'home' ) );
	}
	
	/**
	 * @Route("/newSurvey", name="newSurvey")
	 * @Template()
	 */
	public function newSurveyAction(Request $request) {
		$user = $this->container->get ( 'security.token_storage' )->getToken ()->getUser ();
		$survey = new Survey ();
		$survey->setUser ( $user );
		
		$newSurvey = new newSurvey ();
		$newSurvey->setSurvey ( $survey );
		
		$surveyForm = $this->createForm ( newSurveyType::class, $newSurvey );
		$surveyForm->handleRequest ( $request );
		
		if ($surveyForm->isValid () && $surveyForm->isSubmitted ()) {
			
			$survey = $newSurvey->getSurvey ();
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $survey );
			$em->flush ();
			
			return $this->redirect ( $this->generateUrl ( 'newQuestion', array (
					'surveyId' => $survey->getId () 
			) ) );
		}
		return array (
				'surveyForm' => $surveyForm->createView () 
		);
	}
	
	/**
	 * @Route("/editSurvey/{surveyId}", name="editSurvey")
	 * @Template()
	 */
	public function editSurveyAction(Request $request, $surveyId) {
		$em = $this->getDoctrine ()->getManager ();
		$survey = $em->getRepository ( 'MainBundle:Survey' )->find ( $surveyId );
		
		if (! $survey)
			throw $this->createNotFoundException ( 'Wskazany zasób nie istnieje' );
		
		$surveyUser = $survey->getUser ();
		$requestingUser = $this->container->get ( 'security.token_storage' )->getToken ()->getUser ();
		if ($surveyUser != $requestingUser)
			throw $this->createAccessDeniedException ( 'Brak dostępu do zasobu' );
		
		$editSurvey = new EditSurvey ();
		$editSurvey->setSurvey ( $survey );
		
		$surveyForm = $this->createForm ( EditSurveyType::class, $editSurvey );
		$surveyForm->handleRequest ( $request );
		
		if ($surveyForm->isValid () && $surveyForm->isSubmitted ()) {
			
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $editSurvey->getSurvey () );
			$em->flush ();
			
			return $this->redirect ( $this->generateUrl ( 'showSurveyToEdit', array (
					"surveyId" => $surveyId 
			) ) );
		}
		return $this->render ( 'MainBundle:Survey:newSurvey.html.twig', array (
				'surveyForm' => $surveyForm->createView () 
		) );
	}
	
	/**
	 * @Route("/newQuestion/{surveyId}", name="newQuestion")
	 * @Template()
	 */
	public function newQuestionAction(Request $request, $surveyId) {
		$em = $this->getDoctrine ()->getManager ();
		$survey = $em->getRepository ( 'MainBundle:Survey' )->find ( $surveyId );
		
		if (! $survey)
			throw $this->createNotFoundException ( 'Wskazany zasób nie istnieje' );
		
		$surveyUser = $survey->getUser ();
		$requestingUser = $this->container->get ( 'security.token_storage' )->getToken ()->getUser ();
		if ($surveyUser != $requestingUser)
			throw $this->createAccessDeniedException ( 'Brak dostępu do zasobu' );
		
		$nextQuestionNumber = count($survey->getQuestions()) + 1;
				
		$question = new Question ();
		$newQuestion = new newQuestion ();
		$newQuestion->setQuestion ( $question );
		
		$questionForm = $this->createForm ( AddQuestionType::class, $newQuestion );
		$questionForm->handleRequest ( $request );
		
		if ($questionForm->isSubmitted () && $questionForm->isValid ()) {
			
			$question = $newQuestion->getQuestion ();
			$question->setSurvey ( $survey );
			
			$nextPosition = $survey->getNextQuestionPosition ();
			$question->setPosition ( $nextPosition );
			
			$em->persist ( $question );
			
			$options = $question->getOptions ();
			foreach ( $options as $option ) {
				$option->setQuestion ( $question );
				$em->persist ( $option );
			}
			$em->flush ();
			
			$nextAction = $questionForm->get ( 'endCreateSurvey' )->isClicked () ? 'showSurveyToEdit' : 'newQuestion';
			return $this->redirect ( $this->generateUrl ( $nextAction, array (
					'surveyId' => $surveyId 
			) ) );
		}
		return array (
				'questionForm' => $questionForm->createView (),
				'nextQuestionNumber'=> $nextQuestionNumber
		);
	}
	/**
	 * @Route("/editQuestion/{questionId}", name="editQuestion")
	 * @Template()
	 */
	public function editQuestionAction(Request $request, $questionId) {
		$em = $this->getDoctrine ()->getManager ();
		$question = $em->getRepository ( 'MainBundle:Question' )->find ( $questionId );
		if (! $question)
			throw $this->createNotFoundException ( 'Brak zasobu do edycji' );
		
		$surveyUser = $question->getSurvey()->getUser ();
		$requestingUser = $this->container->get ( 'security.token_storage' )->getToken ()->getUser ();
		if ($surveyUser != $requestingUser)
			throw $this->createAccessDeniedException ( 'Brak uprawnień do zasobu' );
		
		$options = $question->getOptions ();
		$originalOptions = new ArrayCollection ();
		foreach ( $options as $option ) {
			$originalOptions->add ( $option );
		}
		
		$editQuestion = new EditQuestion ();
		$editQuestion->setQuestion ( $question );
		
		$questionForm = $this->createForm ( EditQuestionType::class, $editQuestion );
		$questionForm->handleRequest ( $request );
		
		if ($questionForm->isSubmitted () && $questionForm->isValid ()) {
			
			$question = $editQuestion->getQuestion ();
			$options = $question->getOptions ();
			$em->persist ( $question );
			
			foreach ( $originalOptions as $orginalOption ) {
				if (false === $options->contains ( $orginalOption ))
					$em->remove ( $orginalOption );
			}
			foreach ( $options as $option ) {
				$em->persist ( $option );
			}
			$em->flush ();
			
			$surveyId = $question->getSurvey()->getId();
			return $this->redirect ( $this->generateUrl ( 'showSurveyToEdit', array (
					'surveyId' => $surveyId 
			) ) );
		}
		
		return array (
				'questionForm' => $questionForm->createView (),
				'question' => $question 
		);
	}
	
	/**
	 * @Route("/results/{surveyId}", name="results")
	 * @Template()
	 */
	public function resultsAction($surveyId) {
		$em = $this->getDoctrine ()->getManager ();
		$survey = $em->getRepository ( 'MainBundle:Survey' )->find ($surveyId );
		$questions = $survey->getQuestions();
		
		return array (
				'questions' => $questions,
				'survey' => $survey
		);
	}
	
	/**
	 * @Route("/deleteSurvey/{surveyId}", name="deleteSurvey")
	 */
	public function deleteSurveyAction($surveyId) {
		$em = $this->getDoctrine ()->getManager ();
		$survey = $em->getRepository ( 'MainBundle:Survey' )->find ( $surveyId );
		$em->remove ( $survey );
		$em->flush ();
		
		return $this->redirect ( $this->generateUrl ( 'panel' ) );
	}
	
	/**
	 * @Route("/deleteQuestion/{questionId}", name="deleteQuestion")
	 */
	public function deleteQuestionAction($questionId) {
		$em = $this->getDoctrine ()->getManager ();
		$question = $em->getRepository ( 'MainBundle:Question' )->find ( $questionId );
		
		$survey = $question->getSurvey ();
		
		$em->remove ( $question );
		$em->flush ();
		
		return $this->redirect ( $this->generateUrl ( 'showSurveyToEdit', array (
				'surveyId' => $survey->getId () 
		) ) );
	}
	
	/**
	 * @Route("/changePositionQuestion/{questionId}/{schift}", name="changePositionQuestion")
	 */
	public function changePositionAction($questionId, $schift) {
		$repository = $this->getDoctrine ()->getRepository ( 'MainBundle:Question' );
		$selectedQuestion = $repository->findOneById ( $questionId );
		$surveyId = $selectedQuestion->getSurvey ()->getId ();
		
		$startingPosition = $selectedQuestion->getPosition ();
		$targetPosition = $startingPosition - $schift;
		
		$secondQuestion = $repository->findOneBy ( array (
				'position' => $targetPosition,
				'survey' => $surveyId 
		) );
		
		$selectedQuestion->setPosition ( $targetPosition );
		$secondQuestion->setPosition ( $startingPosition );
		
		$em = $this->getDoctrine ()->getManager ();
		$em->persist ( $selectedQuestion );
		$em->persist ( $secondQuestion );
		$em->flush ();
		
		return $this->redirect ( $this->generateUrl ( 'showSurveyToEdit', array (
				'surveyId' => $surveyId 
		) ) );
	}
}
