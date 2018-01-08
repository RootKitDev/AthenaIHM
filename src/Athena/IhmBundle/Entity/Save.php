<?php

namespace Athena\IhmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Save
*
* @ORM\Table(name="save")
* @ORM\Entity(repositoryClass="Athena\IhmBundle\Repository\SaveRepository")
*/
class Save {
	/**
	* @var int
	*
	* @ORM\Column(name="day", type="integer")
	* @ORM\ManyToOne(targetEntity="Athena\IhmBundle\Entity\Time")
	* @ORM\JoinColumn(nullable=false)
	* @ORM\Id
	*/
	private $day;

	/**
	* @var int
	*
	* @ORM\Column(name="month", type="integer")
	* @ORM\ManyToOne(targetEntity="Athena\IhmBundle\Entity\Time")
	* @ORM\JoinColumn(nullable=false)
	* @ORM\Id
	*/
	private $month;

	/**
	* @var int
	*
	* @ORM\Column(name="state", type="integer")
	* @ORM\ManyToOne(targetEntity="Athena\IhmBundle\Entity\State")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $state;

	/**
	* @var int
	*
	* @ORM\Column(name="size", type="integer")
	*/
	private $size;

	/**
	* @var int
	*
	* @ORM\Column(name="type", type="integer")
	* @ORM\ManyToOne(targetEntity="Athena\IhmBundle\Entity\Type")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $type;

####################################################
#		GETTER
####################################################

	/**
	* Get day
	*
	* @return int
	*/
	public function getDay() {
		return $this->day;
	}

	/**
	* Get month
	*
	* @return int
	*/
	public function getMonth() {
		return $this->month;
	}

	/**
	* Get state
	*
	* @return int
	*/
	public function getState() {
		return $this->state;
	}

	/**
	* Get size
	*
	* @return int
	*/
	public function getSize() {
		return $this->size;
	}

	/**
	* Get type
	*
	* @return int
	*/
	public function getType() {
		return $this->type;
	}

####################################################
#		SETTER
####################################################

	/**
	* Set day
	*
	* @param integer $day
	*
	* @return Save
	*/
	public function setDay($day) {
		$this->day = $day;
		return $this;
	}

	/**
	* Set month
	*
	* @param integer $month
	*
	* @return Save
	*/
	public function setMonth($month) {
		$this->month = $month;
		return $this;
	}

	/**
	* Set state
	*
	* @param integer $state
	*
	* @return Save
	*/
	public function setState($state) {
		$this->state = $state;
		return $this;
	}

	/**
	* Set size
	*
	* @param integer $size
	*
	* @return Save
	*/
	public function setSize($size) {
		$this->size = $size;
		return $this;
	}

	/**
	* Set type
	*
	* @param integer $type
	*
	* @return Save
	*/
	public function setType($type) {
		$this->type = $type;
		return $this;
	}


}

