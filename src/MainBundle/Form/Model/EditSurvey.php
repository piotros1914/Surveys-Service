<?php

namespace MainBundle\Form\Model;

class EditSurvey {
	
	protected $survey;
	
	public function getSurvey() {
		return $this->survey;
	}
	
	public function setSurvey($survey) {
		$this->survey = $survey;
		return $this;
	}
}