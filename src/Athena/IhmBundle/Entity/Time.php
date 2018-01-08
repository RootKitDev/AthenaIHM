<?php

namespace Athena\IhmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Time
*
* @ORM\Table(name="time")
* @ORM\Entity(repositoryClass="Athena\IhmBundle\Repository\TimeRepository")
*/
class Time {

	/**
	* @var int
	*
	* @ORM\Column(name="day", type="integer")
	* @ORM\Id
	*/
	private $day;

	/**
	* @var int
	*
	* @ORM\Column(name="month", type="integer")
	* @ORM\Id
	*/
	private $month;

	/**
	* @var \DateTime
	*
	* @ORM\Column(name="AVG_Time", type="time")
	*/
	private $avg_Time;

	/**
	* @var \DateTime
	*
	* @ORM\Column(name="AVG_Time_SQL", type="time")
	*/
	private $avg_Time_SQL;

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
	* Get avg_Time
	*
	* @return \DateTime
	*/
	public function getAVGTime() {
		return $this->avg_Time;
	}

	/**
	* Get avg_Time_SQL
	*
	* @return \DateTime
	*/
	public function getAVGTimeSQL() {
		return $this->avg_Time_SQL;
	}

####################################################
#		SETTER
####################################################

	/**
	* Set day
	*
	* @param integer $day
	*
	* @return Time
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
	* @return Time
	*/
	public function setMonth($month) {
		$this->month = $month;
		return $this;
	}

	/**
	* Set avg_Time
	*
	* @param \DateTime $avg_Time
	*
	* @return Time
	*/
	public function setAVGTime($avg_Time) {
		$this->aVGTime = $avg_Time;
		return $this;
	}

	/**
	* Set avg_Time_SQL
	*
	* @param \DateTime $avg_Time_SQL
	*
	* @return Time
	*/
	public function setAVGTimeSQL($avg_Time_SQL) {
		$this->aVGTimeSQL = $avg_Time_SQL;

		return $this;
	}
}

