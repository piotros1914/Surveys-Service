<?php

namespace MainBundle\Repository;


class AnswerRepository extends \Doctrine\ORM\EntityRepository
{
	public function findLastAnswer($questionId, $max = null, $offset = null) {
		$qb = $this->_em->createQueryBuilder('p');
		$qb->select('p')
		->from('MainBundle:Answer', 'p')
		->where('p.question = :question')
		->setParameter('question', $questionId)
		->setFirstResult($offset)
		->setMaxResults($max);

		return $qb->getQuery ()->getResult ();
		
	}
	
}
