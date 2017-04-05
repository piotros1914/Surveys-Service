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
		->where('p.visibility = :visibility')
		->orderBy('p.addedDate', 'DESC')
		->setParameter('visibility', true)
		->setMaxResults($max)
		->getQuery();
		
		$surveys = $query->getResult();
		$now = new \DateTime();
		
		return array('surveys' => $surveys,
				'now' => $now
		);
	}
	
	/**
	 * @Template()
	 */
	public function popularSurveysAction($max = 3)
	{
		$repository = $this->getDoctrine()->getRepository('MainBundle:Survey');
		
		$query = $repository->createQueryBuilder('p')
		->where('p.visibility = :visibility')
		->orderBy('p.responesNumber', 'DESC')
		->setParameter('visibility', true)
		->setMaxResults($max)
		->getQuery();
		
		$surveys = $query->getResult();
		$now = new \DateTime();
	
		return array('surveys' => $surveys,
						'now' => $now
		);
	}
	
	/**
	 * @Template()
	 */
	public function allSurveysAction()
	{
		$now = new \DateTime('now');
		$delay = new \DateTime('last month');
		$repository = $this->getDoctrine()->getRepository('MainBundle:Survey');
		
		$query = $repository->createQueryBuilder('p')
		->where('p.addedDate <= :now')
		->andWhere('p.addedDate >= :delay')
		->setParameter('now', $now)
		->setParameter('delay', $delay)
		->getQuery();
		
		$surveys = $query->getResult();
		$surveysNumber = count ($surveys);
		
		return array('surveysNumber' => $surveysNumber);
		
		
		return array();
	}
	
	/**
	 * @Template()
	 */
	public function allResultsAction()
	{
		return array();
	}
	
	/**
	 * @Template()
	 */
	public function paginationAction($page = 1, $pagesQuantity = 1)
	{
		$size = 5;
		
		if( $pagesQuantity <= $size){
			$size = $pagesQuantity;
		}
		

		$offset = (int) ($size/2);
		
		
		if($page > $offset){
			
			
			if($page > ($pagesQuantity - $offset)){
				$lastPage = $pagesQuantity;
				$firstPage = $lastPage - $size + 1;
			}
			else{
				
				$firstPage = $page - $offset;
				$lastPage = $page + $offset;
			}
				
		}	
		
		else {
			$firstPage = 1;
			$lastPage = $size;
		}
		
		
		
		
		
		$nextPage = $page + 1;
		$previousPage = $page - 1;
		if($previousPage <= 0)
			$previousPage = 1;
		if($nextPage >= $pagesQuantity)
			$nextPage = $pagesQuantity;
		
	

		return array(
				'firstPage' =>$firstPage,
				'lastPage' =>$lastPage,
				'currentPage' => $page,
				'previousPage' => $previousPage,
				'nextPage' => $nextPage
		);
	}
	
	
	

}
