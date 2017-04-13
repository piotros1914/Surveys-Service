<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="visit_counter")
 * @ORM\Entity
 */
class VisitCounter {
	
	
	/**
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 *
	 * @ORM\Column(name="date", type="datetime")
	 */
	private $date;
	
	/**
	 * @ORM\Column(name="visits", type="integer")
	 */
	private $visits;
	
	public function __construct() {
		$this->date = new \DateTime ();
		$this->visits = 1;
	
	}
	
	

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return VisitCounter
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set visits
     *
     * @param integer $visits
     *
     * @return VisitCounter
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;

        return $this;
    }

    /**
     * Get visits
     *
     * @return integer
     */
    public function getVisits()
    {
        return $this->visits;
    }
}
