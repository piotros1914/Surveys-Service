<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MainBundle\Form\DynamicQuestion;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     * 
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/about", name="about")
     * @Template()
     *
     */
    public function aboutAction()
    {
    	return array();
    }
    
    /**
     * @Route("/survey/{surveyId}", name="survey")
     * @Template()
     */
    public function surveyAction($surveyId){
    
    
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
    
   
    
 	
}
