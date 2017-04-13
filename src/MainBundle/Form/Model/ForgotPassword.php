<?php

namespace MainBundle\Form\Model;

class ForgotPassword {
	protected $email;
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
}