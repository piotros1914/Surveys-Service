<?php

namespace MainBundle\Form\Model;

class newQuestion {
	
	protected $question;
	
	public function getQuestion() {
		return $this->question;
	}
	public function setQuestion($question) {
		$this->question = $question;
		return $this;
	}
	
	
	
}