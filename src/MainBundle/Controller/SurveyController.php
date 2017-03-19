<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MainBundle\Entity\Survey;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Form\SurveyType;
use MainBundle\Form\QuestionType;
use MainBundle\Form\DynamicQuestion;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use MainBundle\Entity\Answer;
use Symfony\Component\HttpFoundation\Response;
use MainBundle\Model\AnswerRecorder;


class SurveyController extends Controller
{
    
    /**
     * @Route("/showAllSurveys", name="showAllSurveys")
     * @Template()
     */
    public function showAllSurveysAction(){
    	
    	if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
    	{
    		$user = $this->container->get('security.token_storage')->getToken()->getUser();
    		$userId = $user->getId();
    	}
    	
    	$survey = $this->getDoctrine()->getRepository('MainBundle:Survey')->findByuserId($userId);
    	return array('survey' => $survey);
    }
    
    /**
     * @Route("/showSurvey/{surveyId}", name="showSurvey")
     * @Template()
     */
    public function showSurveyAction($surveyId){
    	
    	$survey = $this->getDoctrine()->getRepository('MainBundle:Survey')->find($surveyId);    	
    	$questions = $this->getDoctrine()->getRepository('MainBundle:Question')->findBy(array('surveyId'=>$surveyId));
    	
    	$form = $this->createFormBuilder();    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$dq = new DynamicQuestion($form, $em);
    
    	foreach ($questions as $question) {
    		$form = $dq->buildQuestion($question);
    	}
    	
    	$form->setAction($this->generateUrl('answer', array('surveyId' => $surveyId)));
    	$form->add('submit', SubmitType::class, array(
    			'label' => "Prześlij",
    			'attr' => array(
    					'class' => 'btn btn-primary')));
    	
    	$form = $form->getForm();
    	return array(
    			'survey' => $survey,   		
    			'form' => $form->createView() 			
    	);
    }
    
    
    /**
     * @Route("/answer/{surveyId}", name="answer")
     */
    public function answerAction(Request $request, $surveyId){
    	   	 	
    	$formData = $request->request->get('form');
    	$em = $this->getDoctrine()->getManager();   	
    	$answerRecorder = new AnswerRecorder($em);
    	
    	$questions = $this->getDoctrine()->getRepository('MainBundle:Question')->findBy(array('surveyId' => $surveyId));
    	foreach($questions as $question) {
    		$answerRecorder->addAnswer($question, $formData[$question->getId()]);   	
    	}
    	
    	$answerRecorder->save();
    	
    	return $this->redirect($this->generateUrl('showAllSurveys'));   		     	
    }
      
    /**
     * @Route("/newSurvey", name="newSurvey")
     * @Template()
     */
    public function newSurveyAction(Request $request){
    	 
    	$survey = new Survey();
    	$survey->setUserId($this->getUser()->getId());
    	$surveyForm = $this->createForm(SurveyType::class, $survey);
    	
    	$questionForm = $this->createForm(QuestionType::class);
    	
    	$surveyForm->handleRequest($request);
    	
    	if($surveyForm->isValid() && $surveyForm->isSubmitted()){
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($survey);
    		$em->flush();
    	}
    	
    	return array('surveyForm' => $surveyForm->createView(), 'questionForm' => $questionForm->createView());
    }
    
    /**
     * @Route("/deleteSurvey/{surveyId}", name="delete")
     */
    public function deleteSurveyAction(Request $request, $surveyId){
    	
    	$em = $this->getDoctrine()->getManager();
    	$survey = $em->getRepository('MainBundle:Survey')->find($surveyId);
    	$questions = $em->getRepository('MainBundle:Question')->findBy(array('surveyId'=>$surveyId));
    	$options = $em->getRepository('MainBundle:Option')->findBy(array('surveyId'=>$surveyId));
    	$answers = $em->getRepository('MainBundle:Answer')->findBy(array('surveyId'=>$surveyId));
    	    
//     	$this->remover($em, $survey);
    	$this->remover($em, $questions);
    	$this->remover($em, $options);
    	$this->remover($em, $answers);
    	$em->remove($survey);
//     	$em->remove($questions);
//     	$em->remove($options);
//     	$em->remove($answers);
    	$em->flush();
    	
    	return $this->redirect($this->generateUrl('showAllSurveys'));
    	 
    }
    private function remover($em, $objects){
    	foreach($objects as $object){
    		$em->remove($object);
    	}
    }
}
