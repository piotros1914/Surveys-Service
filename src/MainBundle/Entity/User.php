<?php

namespace MainBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Adres email jest już używany")
 * @UniqueEntity(fields="username", message="Nazwa użytkownika już jest zajęta")
 */
class User implements UserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=30)
     * @Assert\NotBlank(message="Te pole nie może być puste")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50)
     * @Assert\NotBlank( message="Te pole nie może być puste")
     * @Assert\Email(message="Wpisano nie prawdiłowy adresemail")
     */
    private $email;
	/** 
	 * @var string
   	 * @Assert\NotBlank(message="Te pole nie może być puste")
     * @Assert\Length(max = 4096)
	 */
    private $plainPassword;
    
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;
 

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=40)
     */
    private $role;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registrationDate", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $registrationDate;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="lastLogged", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastLogged;

    
    	public function __construct(){
    		$this->role = 'ROLE_USER';
    		$this->registrationDate = new \DateTime();
    		$this->lastLogged = new \DateTime();
    		
    	}
    
    	
    	public function setUsername($username)
    	{
    		$this->username = $username;
    
    		return $this;
    	}
    
    	/**
    	 * Get username
    	 *
    	 * @return string
    	 */
    	public function getUsername()
    	{
    		return $this->username;
    	}
    
    	/**
    	 * Set email
    	 *
    	 * @param string $email
    	 *
    	 * @return User
    	 */
    	public function setEmail($email)
    	{
    		$this->email = $email;
    
    		return $this;
    	}
    
    	/**
    	 * Get email
    	 *
    	 * @return string
    	 */
    	public function getEmail()
    	{
    		return $this->email;
    	}
    
     
    	/**
    	 * Set password
    	 *
    	 * @param string $password
    	 *
    	 * @return User
    	 */
    	public function setPassword($password)
    	{
    		$this->password = $password;
    
    		return $this;
    	}
    
    	/**
    	 * Get password
    	 *
    	 * @return string
    	 */
    	public function getPassword()
    	{
    		return $this->password;
    	}
    
    
    	public function getId()
    	{
    		return $this->id;
    	}
    
    	public function getRoles() {

    		return array($this->role);   
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
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set lastLogged
     *
     * @param \DateTime $lastLogged
     *
     * @return User
     */
    public function setLastLogged($lastLogged)
    {
        $this->lastLogged = $lastLogged;

        return $this;
    }

    /**
     * Get lastLogged
     *
     * @return \DateTime
     */
    public function getLastLogged()
    {
        return $this->lastLogged;
    }
	public function getPlainPassword() {
		return $this->plainPassword;
	}
	public function setPlainPassword($plainPassword) {
		$this->plainPassword = $plainPassword;
		return $this;
	}
	
    
    
}
