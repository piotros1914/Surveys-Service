<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use MainBundle\Services\QuestionFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/panel")
 */
class ResultsController extends Controller
{
	
	public function resultAction($questionId)
	{
		$em = $this->getDoctrine()->getManager();
		$question = $em->getRepository('MainBundle:Question')->find($questionId);
		
		$type = $question->getType();
		
		switch($type) {
			case QuestionFactory::TEXT_QUESTION:
				$response = $this->textResultAction($question);
				break;
			case QuestionFactory::SINGLE_CHOICE_QUESTION:
				$response = $this->pieCharResultAction($question);
				break;
			case QuestionFactory::MULTIPLE_CHOICE_QUESTION:
				$response = $this->barResultAction($question);
				break;
			default:
				throw new \Exception("Invalid question type");
		}
		return $response;
	}
	
	public function textResultAction($question) {
		$em = $this->getDoctrine ()->getManager ();
		$answers = $em->getRepository ( 'MainBundle:Answer' )->findLastAnswer($question->getId(), 10);
			
		$answerNumber = count ( $answers );
		$dataIsEmpty = true;
		if ($answerNumber != 0)
			$dataIsEmpty = false;
		
		return $this->render ( 'MainBundle:Results:textResult.html.twig', array (
				'answers' => $answers,
				'question' => $question,
				'dataIsEmpty' => $dataIsEmpty 
		));
	}
	
	public function pieCharResultAction($question) {
		$dataIsEmpty = true;
		$answers = $question->getAnswers ();
		$options = $question->getOptions ();
		foreach ( $answers as $answer ) {
			foreach ( $options as $option ) {
				if ($option->getOptionText () == $answer->getAnswerText ()) {
					$option->answerNumberIncrease ();
					$dataIsEmpty = false;
				}
			}
		}
		
		return $this->render ( 'MainBundle:Results:pieCharResult.html.twig', array (
				'options' => $options,
				'question' => $question,
				'dataIsEmpty' => $dataIsEmpty 
		));
	}
	
	public function barResultAction($question) {
		$dataIsEmpty = true;
		$answers = $question->getAnswers ();
		$options = $question->getOptions ();
		foreach ( $answers as $answer ) {
			foreach ( $options as $option ) {
				if ($option->getOptionText () == $answer->getAnswerText ()) {
					$option->answerNumberIncrease ();
					$dataIsEmpty = false;
				}
			}
		}
		
		return $this->render('MainBundle:Results:barResult.html.twig', array(
				'options' => $options,
				'question' => $question,
				'dataIsEmpty' => $dataIsEmpty,
	
		));
	}
	
	/**
	 * @Route("/allTextResult/{questionId}", name="allTextResult")
	 * @Template()
	 */
	public function allTextResultsAction($questionId) {
		$em = $this->getDoctrine ()->getManager ();
		$question = $em->getRepository ( 'MainBundle:Question' )->find ( $questionId );
		$survey = $question->getSurvey ();
		$answers = $question->getAnswers ();
		
		return array (
				'answers' => $answers,
				'question' => $question,
				'survey' => $survey 
		);
	}
}
