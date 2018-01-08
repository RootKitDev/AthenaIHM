<?php

namespace Athena\IhmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* State
*
* @ORM\Table(name="state")
* @ORM\Entity(repositoryClass="Athena\IhmBundle\Repository\StateRepository")
*/
class State
{
	/**
	* @var int
	*
	* @ORM\Column(name="id", type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	* @var string
	*
	* @ORM\Column(name="displayState", type="string", length=10)
	*/
	private $displayState;

####################################################
#		GETTER
####################################################
	/**
	* Get id
	*
	* @return int
	*/
	public function getId() {
		return $this->id;
	}

/**
	* Get displayState
	*
	* @return string
	*/
	public function getDisplayState() {
		return $this->displayState;
	}

####################################################
#		SETTER
####################################################

	/**
	* Set displayState
	*
	* @param string $displayState
	*
	* @return State
	*/
	public function setDisplayState($displayState) {
		$this->displayState = $displayState;
		return $this;
	}
}

