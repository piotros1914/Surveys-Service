<?php

namespace MainBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;



/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Adres email jest już używany")
 */
class User implements UserInterface {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer")
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 *
	 * @var string @ORM\Column(name="email", type="string", length=50, unique=true)
	 *      @Assert\NotBlank( message="Te pole nie może być puste")
	 *      @Assert\Email(message="Wpisano nie prawdiłowy adresemail")
	 */
	private $email;
	/**
	 *
	 * @var string @Assert\NotBlank(message="Te pole nie może być puste")
     * @Assert\Length(
     *      min = 6,
     *      max = 50,
     *      minMessage = "Twoje hasło nie może być krótsze niż 6 znaków",
     *      maxMessage = "Twoje hasło nie może być dłuższe niż 50 znaków"
     * )     
	 */
	private $plainPassword;
	
	
	
	
	/**
	 *
	 * @ORM\Column(name="password", type="string", length=64)
	 * 
	 */
	private $password;

	
	/**
	 *
	 * @var string @ORM\Column(name="role", type="string", length=40)
	 */
	private $role;
	
	/**
	 *
	 * @var \DateTime @ORM\Column(name="registrationDate", type="datetime")
	 */
	private $registrationDate;
	
	/**
	 *
	 * @var \DateTime @ORM\Column(name="lastLogged", type="datetime")
	 */
	private $lastLogged;
	
	/**
	 * @ORM\OneToMany(targetEntity="Survey", mappedBy="user", orphanRemoval=true)
	 */
	private $surveys;
	public function __construct() {
		$this->role = 'ROLE_USER';
		$this->registrationDate = new \DateTime ();
		$this->lastLogged = new \DateTime ();
		$this->surveys = new ArrayCollection ();
	}
	
	/**
	 * Get username
	 *
	 * @return string
	 */
	public function getUsername() {
		return $this->email;
	}
	
	/**
	 * Set email
	 *
	 * @param string $email        	
	 *
	 * @return User
	 */
	public function setEmail($email) {
		$this->email = $email;
		
		return $this;
	}
	
	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * Set password
	 *
	 * @param string $password        	
	 *
	 * @return User
	 */
	public function setPassword($password) {
		$this->password = $password;
		
		return $this;
	}
	
	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}
	public function getId() {
		return $this->id;
	}
	public function getRoles() {
		return array (
				$this->role 
		);
	}
	public function getSalt() {
		return null;
	}
	public function eraseCredentials() {
	}
	
	/**
	 * Set registrationDate
	 *
	 * @param \DateTime $registrationDate        	
	 *
	 * @return User
	 */
	public function setRegistrationDate($registrationDate) {
		$this->registrationDate = $registrationDate;
		
		return $this;
	}
	
	/**
	 * Get registrationDate
	 *
	 * @return \DateTime
	 */
	public function getRegistrationDate() {
		return $this->registrationDate;
	}
	
	/**
	 * Set role
	 *
	 * @param string $role        	
	 *
	 * @return User
	 */
	public function setRole($role) {
		$this->role = $role;
		
		return $this;
	}
	
	/**
	 * Get role
	 *
	 * @return string
	 */
	public function getRole() {
		return $this->role;
	}
	
	/**
	 * Set lastLogged
	 *
	 * @param \DateTime $lastLogged        	
	 *
	 * @return User
	 */
	public function setLastLogged($lastLogged) {
		$this->lastLogged = $lastLogged;
		
		return $this;
	}
	
	/**
	 * Get lastLogged
	 *
	 * @return \DateTime
	 */
	public function getLastLogged() {
		return $this->lastLogged;
	}
	public function getPlainPassword() {
		return $this->plainPassword;
	}
	public function setPlainPassword($plainPassword) {
		$this->plainPassword = $plainPassword;
		return $this;
	}
	
	/**
	 *
	 * @var \DateTime
	 */
	private $registrationdate = 'CURRENT_TIMESTAMP';
	
	/**
	 *
	 * @var \DateTime
	 */
	private $lastlogged = 'CURRENT_TIMESTAMP';
	
	/**
	 * Add survey
	 *
	 * @param \MainBundle\Entity\Survey $survey        	
	 *
	 * @return User
	 */
	public function addSurvey(\MainBundle\Entity\Survey $survey) {
		$this->surveys [] = $survey;
		
		return $this;
	}
	
	/**
	 * Remove survey
	 *
	 * @param \MainBundle\Entity\Survey $survey        	
	 */
	public function removeSurvey(\MainBundle\Entity\Survey $survey) {
		$this->surveys->removeElement ( $survey );
	}
	
	/**
	 * Get surveys
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getSurveys() {
		return $this->surveys;
	}
}
