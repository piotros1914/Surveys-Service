<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MainBundle\Entity\Survey;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Form\SurveyType;


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
    	
    	$survey = $this->getDoctrine()->getRepository('MainBundle:Survey')->findOneBy(array('id'=>$surveyId));
    	return array('survey' => $survey);
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
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($survey);
    		$em->flush();
    	}
    	
    	return array('surveyForm' => $surveyForm->createView());
    }
}
