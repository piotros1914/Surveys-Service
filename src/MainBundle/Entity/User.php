<?php

namespace MainBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
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
     * @ORM\Column(name="username", type="string", length=30, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reg_date", type="datetime", nullable=true)
     */
    private $regDate;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=30, nullable=true)
     */
    private $role;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=45, nullable=false)
     */
    private $password;
    
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
    	 * Set regDate
    	 *
    	 * @param \DateTime $regDate
    	 *
    	 * @return User
    	 */
    	public function setRegDate($regDate)
    	{
    		$this->regDate = $regDate;
    
    		return $this;
    	}
    
    	/**
    	 * Get regDate
    	 *
    	 * @return \DateTime
    	 */
    	public function getRegDate()
    	{
    		return $this->regDate;
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
    	 * Set lastLogin
    	 *
    	 * @param \DateTime $lastLogin
    	 *
    	 * @return User
    	 */
    	public function setLastLogin($lastLogin)
    	{
    		$this->lastLogin = $lastLogin;
    
    		return $this;
    	}
    
    	/**
    	 * Get lastLogin
    	 *
    	 * @return \DateTime
    	 */
    	public function getLastLogin()
    	{
    		return $this->lastLogin;
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
    		// 		return $this->role;
    		return array('ROLE_ADMIN');
    
    	}
    
    
    	public function getSalt() {
    		return null;
    	}
    
    
    	public function eraseCredentials() {
    
    	}
    
    }
