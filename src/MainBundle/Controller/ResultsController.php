<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use MainBundle\Services\QuestionFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



/**
 * @Route("/panel")
 */
class ResultsController extends Controller
{
	
	public function resultAction($questionId)
	{
		$em = $this->getDoctrine()->getManager();
		$question = $em->getRepository('MainBundle:Question')->find($questionId);
		
		if($question->getType() == QuestionFactory::TEXT_QUESTION){
			$response = $this->textResultAction($questionId);
			return $response;
		}
		
		if($question->getType() == QuestionFactory::SINGLE_CHOICE_QUESTION){
			$response = $this->charResultAction($questionId);
			return $response;
		}
		
		if($question->getType() == QuestionFactory::MULTIPLE_CHOICE_QUESTION){
			$response = $this->barResultAction($questionId);
			return $response;
		}
		
		
				

		return new Response('brak');
	}
	
	
	/**
	 * @Route("/textResult/{$questionId}", name="textResult")
	 * 
	 */	
	public function textResultAction($questionId)
	{		
		$em = $this->getDoctrine()->getManager();
		$answers = $em->getRepository('MainBundle:Answer')->findBy(array('questionId'=>$questionId), array(),3);
		$question = $em->getRepository('MainBundle:Question')->find($questionId);
		
		return $this->render('MainBundle:Results:textResult.html.twig', array(
				'answers' => $answers,
				'question' => $question
				
		));		
	}
	
	/**
	 * @Route("/charResult/{$questionId}", name="charResult")
	 *
	 */
	public function charResultAction($questionId)
	{
		$em = $this->getDoctrine()->getManager();
		$answers = $em->getRepository('MainBundle:Answer')->findBy(array('questionId'=>$questionId));
		$options = $em->getRepository('MainBundle:Option')->findBy(array('questionId'=>$questionId));
		$question = $em->getRepository('MainBundle:Question')->find($questionId);
		foreach ($answers as $answer){
			foreach ($options as $option){
					if($option->getOptionText() == $answer->getAnswerText() )
						$option->answerNumberIncrease();
					
			}
			
		}
		return $this->render('MainBundle:Results:charResult.html.twig', array(
				'options' => $options,
				'question' => $question,
				
		));
	}
	
	/**
	 * @Route("/barResult/{$questionId}", name="barResult")
	 *
	 */
	public function barResultAction($questionId)
	{
		$em = $this->getDoctrine()->getManager();
		$answers = $em->getRepository('MainBundle:Answer')->findBy(array('questionId'=>$questionId));
		$options = $em->getRepository('MainBundle:Option')->findBy(array('questionId'=>$questionId));
		$question = $em->getRepository('MainBundle:Question')->find($questionId);
		foreach ($answers as $answer){
			foreach ($options as $option){
				if($option->getOptionText() == $answer->getAnswerText() )
					$option->answerNumberIncrease();
						
			}
				
		}
		return $this->render('MainBundle:Results:barResult.html.twig', array(
				'options' => $options,
				'question' => $question,
	
		));
	}
	
	


}
