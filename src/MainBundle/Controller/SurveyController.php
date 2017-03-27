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
use Symfony\Component\HttpFoundation\JsonResponse;
use MainBundle\Entity\Question;
use MainBundle\Entity\Option;

/**
 * @Route("/panel")
 */
class SurveyController extends Controller
{
    
	
	/**
	 * @Route("/", name="panel")
	 * @Template()
	 */
	public function panelAction()
	{
		return array();
	}
		
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
    	
    	$surveys = $this->getDoctrine()->getRepository('MainBundle:Survey')->findByuserId($userId);
    	return array('surveys' => $surveys);
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
    	
    	$survey = $em->getRepository('MainBundle:Survey')->find($surveyId);
    	$survey->setResponesNumber($survey->getResponesNumber() + 1);
    	$em->persist($survey);
    	$em->flush();
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
       	
    	$surveyForm->handleRequest($request);
    	
    	if($surveyForm->isValid() && $surveyForm->isSubmitted()){
    			
    		if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
    		{
    			$em = $this->getDoctrine()->getManager();
    			$user = $this->container->get('security.token_storage')->getToken()->getUser();
    			$userId = $user->getId();
    			$survey->setUserId($userId);
    			 
    			$em->persist($survey);
    			$em->flush();
    			
    			
    		}
    	
    		return $this->redirect($this->generateUrl('newQuestion', array('surveyId'=> $survey->getId())));
	
    	}
    	   
    	return array('surveyForm' => $surveyForm->createView());
    }
    
    
    /**
     * @Route("/newQuestion/{surveyId}", name="newQuestion")
     * @Template()
     */
    public function newQuestionAction(Request $request, $surveyId){
    
    	$question = new Question();
    	$question ->setSurveyId($surveyId);
    	    
    	$option1 = new Option();
    	$option1->setOptionText('Twoja opcja');
    	
    	$question->getOptions()->add($option1);

    	$questionForm = $this->createForm(QuestionType::class, $question);  	 
    	$questionForm->handleRequest($request);
    	 
    	if ($questionForm->isValid()) {
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($question);
    		$em->flush();
    		  
    		$options = $question->getOptions();
    		$questionId = $question->getId();
    		
	    	foreach ($options as $option) {
	    		$option->setQuestionId($questionId);
	    		$option->setSurveyId($surveyId);
	    		    		
 	    		$em->persist($option);    		
    		}
    		$em->flush();

    		$nextAction = $questionForm->get('endCreateSurvey')->isClicked() ? 'showSurvey' : 'newQuestion';
    		return $this->redirect($this->generateUrl($nextAction, array("surveyId" => $surveyId)));
    		
    	}
    	return array('questionForm' => $questionForm->createView());
    	
    }
    /**
     * @Route("/editQuestion/{questionId}", name="editQuestion")
     * @Template()
     */
    public function editQuestionAction(Request $request, $surveyId){
    
    
    
    
    	return array();
    	 
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
