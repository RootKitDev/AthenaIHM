<?php

namespace Athena\IhmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Partner
*
* @ORM\Table(name="partner")
* @ORM\Entity(repositoryClass="Athena\IhmBundle\Repository\PartnerRepository")
*/
class Partner {

	/**
	* @var string
	*
	* @ORM\Column(name="host", type="string", length=255)
	* @ORM\Id
	*/
	private $host;

	/**
	* @var string
	*
	* @ORM\Column(name="ip", type="string", length=15)
	*/
	private $ip;



####################################################
#		GETTER
####################################################

	/**
	* Get host
	*
	* @return string
	*/
	public function getHost() {
		return $this->host;
	}

	/**
	* Get ip
	*
	* @return string
	*/
	public function getIp() {
		return $this->ip;
	}

####################################################
#		SETTER
####################################################
	/**
	* Set host
	*
	* @param string $host
	*
	* @return Partner
	*/
	public function setHost($host) {
		$this->host = $host;

		return $this;
	}

	/**
	* Set ip
	*
	* @param string $ip
	*
	* @return Partner
	*/
	public function setIp($ip) {
		$this->ip = $ip;

		return $this;
	}

}