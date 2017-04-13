<?php

namespace MainBundle\Services;

class PasswordGenerator {
	
	private $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
	
	public function generateRandomPassword($max = 6) {
		$string = '';
		$max = strlen ( $this->characters ) - 1;
		
		for($i = 0; $i < 6; $i ++) {
			$string .= $this->characters [mt_rand ( 0, $max )];
		}
		
		return $string;
	}
}