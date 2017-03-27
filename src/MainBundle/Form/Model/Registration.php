<?php

namespace MainBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use MainBundle\Entity\User;

class Registration
{
	/**
	 * @Assert\Type(type="MainBundle\Entity\User")
	 * @Assert\Valid()
	 */
	protected $user;

	/**
	 *
	 */
	protected $terms;
	
	public function __construct()
	{
		$this->user = new User();
	}

	public function setUser(User $user)
	{
		$this->user = $user;
	}

	public function getUser()
	{
		return $this->user;
	}
	public function getTerms() {
		return $this->terms;
	}
	public function setTerms($terms) {
		$this->terms = (bool) $terms;
		return $this;
	}
	
}