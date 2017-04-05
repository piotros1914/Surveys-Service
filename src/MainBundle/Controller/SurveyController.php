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
use MainBundle\Model\AnswerRecorder;
use MainBundle\Entity\Question;
use MainBundle\Entity\Option;
use Doctrine\Common\Collections\ArrayCollection;
use MainBundle\Form\EditSurveyType;
use MainBundle\Form\Model\EditSurvey;
use MainBundle\Form\Model\AddSurvey;
use MainBundle\Form\AddSurveyType;
use MainBundle\Form\Model\EditQuestion;
use MainBundle\Form\EditQuestionType;
use MainBundle\Form\Model\AddQuestion;
use MainBundle\Form\AddQuestionType;
use MainBundle\Form\newSurveyType;
use MainBundle\Form\Model\newSurvey;
use MainBundle\Form\Model\newQuestion;
use MainBundle\Model\SurveyBuilder;

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
    	  
    	$user = $this->container->get('security.token_storage')->getToken()->getUser();
    	$userId = $user->getId();   	  	
    	$surveys = $this->getDoctrine()->getRepository('MainBundle:Survey')->findByuserId($userId);
    	return array('surveys' => $surveys);
    }
    
    /**
     * @Route("/showSurveyToEdit/{surveyId}", name="showSurveyToEdit")
     * @Template()
     */
    public function showSurveyToEditAction($surveyId){
    	
    	$em = $this->getDoctrine()->getManager();
    	$form = $this->createFormBuilder();
    	 
    	$surveyBuilder = new SurveyBuilder($surveyId, $em, $form);
    	return array(
    			'survey' => $surveyBuilder->getSurvey(),   		
    			'form' => $surveyBuilder->createSurveyEditForm() 			
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
    	
    	$newSurvey = new newSurvey();
    	$newSurvey->setSurvey($survey);
    	
    	$surveyForm = $this->createForm(newSurveyType::class, $newSurvey);       	
    	$surveyForm->handleRequest($request);
    	
    	if($surveyForm->isValid() && $surveyForm->isSubmitted()){

    		$survey = $newSurvey->getSurvey();
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($survey);
    		$em->flush();
    	
    		return $this->redirect($this->generateUrl('newQuestion', array('surveyId'=> $survey->getId())));
    	}   
    	return array('surveyForm' => $surveyForm->createView());
    } 
    
    /**
     * @Route("/editSurvey/{surveyId}", name="editSurvey")
     * @Template()
     */
    public function editSurveyAction(Request $request, $surveyId){
    	
    	$em = $this->getDoctrine()->getManager();
    	$survey = $em->getRepository('MainBundle:Survey')->find($surveyId);
    	
    	$editSurvey = new EditSurvey();
    	$editSurvey->setSurvey($survey);
  
    	$surveyForm = $this->createForm(EditSurveyType::class, $editSurvey);
    	$surveyForm->handleRequest($request);
    	 
    	if($surveyForm->isValid() && $surveyForm->isSubmitted()){
    
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($editSurvey->getSurvey());
    		$em->flush();
    		 
    		return $this->redirect($this->generateUrl('showSurveyToEdit', array("surveyId" => $surveyId)));
    	}
    	return $this->render('MainBundle:Survey:newSurvey.html.twig', array('surveyForm' => $surveyForm->createView()));
    }
    
    /**
     * @Route("/newQuestion/{surveyId}", name="newQuestion")
     * @Template()
     */
    public function newQuestionAction(Request $request, $surveyId){
    
    	$question = new Question();
    	$question ->setSurveyId($surveyId);
    	
    	$newQuestion = new newQuestion();
    	$newQuestion->setQuestion($question);
    	    
    	$questionForm = $this->createForm(AddQuestionType::class, $newQuestion);  	 
    	$questionForm->handleRequest($request);
    	 
    	if ($questionForm->isValid()) {
    		
    		$question = $newQuestion->getQuestion();
    		
    		$questions = $this->getDoctrine()->getRepository('MainBundle:Question')->findBy(array('surveyId'=>$surveyId));
    		$questionsNumber = count ($questions);
    		$question->setPosition($questionsNumber + 1);
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($question);
    		$em->flush(); 				
    		$questionId = $question->getId();
    		
    		$options = $question->getOptions();
	    	foreach ($options as $option) {
	    		$option->setQuestionId($questionId);
	    		$option->setSurveyId($surveyId);    		    		
 	    		$em->persist($option);    		
    		}
    		$em->flush();

    		$nextAction = $questionForm->get('endCreateSurvey')->isClicked() ? 'showSurveyToEdit' : 'newQuestion';
    		return $this->redirect($this->generateUrl($nextAction, array("surveyId" => $surveyId)));
    	}
    	return array('questionForm' => $questionForm->createView());
    	
    }
    /**
     * @Route("/editQuestion/{questionId}", name="editQuestion")
     * @Template()
     */
    public function editQuestionAction(Request $request, $questionId){
    	
    	$em = $this->getDoctrine()->getManager();
    	$question = $em->getRepository('MainBundle:Question')->find($questionId);
    	 	   	
    	$options = $em->getRepository('MainBundle:Option')->findBy(array('questionId'=>$questionId));
    	$originalOptions = new ArrayCollection();
    	foreach ($options as $option) { 
    		$question->getOptions()->add($option);
    		$originalOptions->add($option);
    	}
    	
    	$editQuestion = new EditQuestion();
    	$editQuestion->setQuestion($question);
    	
    	$questionForm = $this->createForm(EditQuestionType::class, $editQuestion);
    	$questionForm->handleRequest($request);
    	
    	if($questionForm->isSubmitted() && $questionForm->isValid()){
    	   		
    		$question = $editQuestion->getQuestion();
    		$options = $question->getOptions();
    		$questionId = $question->getId();
    		$surveyId = $question->getSurveyId();
    		
    		$em->persist($question);
    					
    		foreach ($originalOptions as $orginalOption) {
    			if (false === $options->contains($orginalOption))  	
    				$em->remove($orginalOption);   				
    		}
		 
    		foreach ($options as $option) {
    			$option->setQuestionId($questionId);
    			$option->setSurveyId($surveyId);
    			$em->persist($option);
    		}
    		$em->flush();
    			 
    		return $this->redirect($this->generateUrl('showSurveyToEdit', array('surveyId' => $surveyId	)));	
    	}
    	
    	return array('questionForm' => $questionForm->createView(),
    				'question'=> $question
    	);
    }
    
    /**
     * @Route("/results/{surveyId}", name="results")
     * @Template()
     */
    public function resultsAction(Request $request, $surveyId){
    	
    	$em = $this->getDoctrine()->getManager();
    	$questions = $em->getRepository('MainBundle:Question')->findBy(array('surveyId'=>$surveyId));
    
    	return array('questions' => $questions);
    }
    
   
    /**
     * @Route("/deleteSurvey/{surveyId}", name="deleteSurvey")
     */
    public function deleteSurveyAction($surveyId){
    	
    	$em = $this->getDoctrine()->getManager();
    
    	$survey = $em->getRepository('MainBundle:Survey')->find($surveyId);	 
    	$questions = $em->getRepository('MainBundle:Question')->findBy(array('surveyId'=>$surveyId));
    	$options = $em->getRepository('MainBundle:Option')->findBy(array('surveyId'=>$surveyId));
    	$answers = $em->getRepository('MainBundle:Answer')->findBy(array('surveyId'=>$surveyId));
    	    
    	$this->arrayRemover($em, $questions);
    	$this->arrayRemover($em, $options);
    	$this->arrayRemover($em, $answers);
    	$em->remove($survey);
  
    	$em->flush();
    	
    	return $this->redirect($this->generateUrl('showAllSurveys'));
 
    }
    
    /**
     * @Route("/deleteQuestion/{questionId}", name="deleteQuestion")
     */
    public function deleteQuestionAction($questionId){
    	 
    	$em = $this->getDoctrine()->getManager();
    		
    	$question = $em->getRepository('MainBundle:Question')->find($questionId);
    	$options = $em->getRepository('MainBundle:Option')->findBy(array('questionId'=>$questionId));
    	$answers = $em->getRepository('MainBundle:Answer')->findBy(array('questionId'=>$questionId));
    		
    	$surveyId = $question->getSurveyId();
    	
    	$this->arrayRemover($em, $options);
    	$this->arrayRemover($em, $answers);
    	$em->arrayRemover($question);
    	$em->persist($option);
    	$em->flush();
    	 
    	return $this->redirect($this->generateUrl('showSurveyToEdit', array("surveyId" => $surveyId)));  
    }
    
    private function arrayRemover($em, $objects){
    	foreach($objects as $object){
    		$em->remove($object);
    	}
    }
    
    /**
     * @Route("/changePositionQuestion/{questionId}/{schift}", name="changePositionQuestion")
     */
   public function changePositionAction($questionId, $schift){
      	 
    	$repository = $this->getDoctrine()->getRepository('MainBundle:Question');
    	$firstQuestion = $repository->findOneById($questionId);
    	$surveyId = $firstQuestion->getSurveyId();
    
    	$beginingPosition = $firstQuestion->getPosition();
    	$targetPosition = $beginingPosition - $schift;
    
    	$secondQuestion = $repository->findOneBy(array(
    			'position' => $targetPosition,
    			'surveyId' => $surveyId
    	));
    
    
    	$firstQuestion->setPosition($targetPosition);
    	$secondQuestion->setPosition($beginingPosition);
    
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($firstQuestion);
    	$em->persist($secondQuestion);
    	$em->flush();
    
    	return $this->redirect($this->generateUrl('showSurveyToEdit', array("surveyId" => $surveyId)));
    
    }
    
    
    
    
}
