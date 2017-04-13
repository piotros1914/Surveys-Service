<?php

namespace MainBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangePassword {
	
	/**
	 * @SecurityAssert\UserPassword(
	 *     message = "Wpisano nieeee prawidłowe hasło"
	 * )
	 */
	protected $oldPassword;
	protected $newPassword;
	
	public function getOldPassword() {
		return $this->oldPassword;
	}
	public function setOldPassword($oldPassword) {
		$this->oldPassword = $oldPassword;
		return $this;
	}
	public function getNewPassword() {
		return $this->newPassword;
	}
	public function setNewPassword($newPassword) {
		$this->newPassword = $newPassword;
		return $this;
	}
}