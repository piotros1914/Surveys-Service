<?php

namespace MainBundle\Form\Model;

class newSurvey {
	
	protected $survey;
	
	public function getSurvey() {
		return $this->survey;
	}
	
	public function setSurvey($survey) {
		$this->survey = $survey;
		return $this;
	}
}