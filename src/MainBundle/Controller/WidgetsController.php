<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class WidgetsController extends Controller
{
	
	/**
	 * @Template()
	 */
	public function lastSurveysAction($max = 3)
	{
		 $repository = $this->getDoctrine()->getRepository('MainBundle:Survey');
		
		 $query = $repository->createQueryBuilder('p')	
		->orderBy('p.addedDate', 'DESC')
		->setMaxResults($max)
		->getQuery();
		
		$surveys = $query->getResult();
		
		
		return array('surveys' => $surveys);
	}
	
	/**
	 * @Template()
	 */
	public function popularSurveysAction($max = 3)
	{
		$repository = $this->getDoctrine()->getRepository('MainBundle:Survey');
		
		$query = $repository->createQueryBuilder('p')
		->orderBy('p.responesNumber', 'DESC')
		->setMaxResults($max)
		->getQuery();
		
		$surveys = $query->getResult();
	
		return array('surveys' => $surveys);
	}

}
