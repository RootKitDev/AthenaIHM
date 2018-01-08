<?php

namespace Athena\IhmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Type
*
* @ORM\Table(name="type")
* @ORM\Entity(repositoryClass="Athena\IhmBundle\Repository\TypeRepository")
*/
class Type {
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
	* @ORM\Column(name="name", type="string", length=30)
	*/
	private $name;

	/**
	* @var string
	*
	* @ORM\Column(name="portee", type="string", length=30)
	*/
	private $portee;

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
	* Get name
	*
	* @return string
	*/
	public function getName() {
		return $this->name;
	}

	/**
	* Get portee
	*
	* @return string
	*/
	public function getPortee() {
		return $this->portee;
	}

####################################################
#		SETTER
####################################################

	/**
	* Set name
	*
	* @param string $name
	*
	* @return Type
	*/
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	* Set portee
	*
	* @param string $portee
	*
	* @return Type
	*/
	public function setPortee($portee) {
		$this->portee = $portee;
		return $this;
	}


}

