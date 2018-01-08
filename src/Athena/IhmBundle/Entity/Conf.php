<?php

namespace Athena\IhmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* Type
*
* @ORM\Table(name="conf")
* @ORM\Entity(repositoryClass="Athena\IhmBundle\Repository\ConfRepository")
*/
class Conf {
	/**
	* @var int
	*
	* @ORM\Column(name="id", type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
	 */

	private $conf;

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
	 * Get conf
	 *
	 * @return string
	 */
	public function getConf() {
	return $this->conf;
	}

####################################################
#		SETTER
####################################################
	/**
	 * Set conf
	 *
	 * @param string $conf
	 *
	 * @return Conf
	 */
	public function setConf($conf) {
		$this->conf = $conf;
		return $this;
	}

}
