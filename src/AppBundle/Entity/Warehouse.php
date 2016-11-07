<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WarehouseRepository")
 */
class Warehouse
{
	const TYPE_STOCK = 'stock';
	const TYPE_STORE = 'store';

	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @Assert\NotBlank()
	 * @var Address
	 * @ORM\OneToOne(targetEntity="Address")
	 */
	private $address;

	/**
	 * @Assert\NotBlank()
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $type;

	/**
	 * @Assert\NotBlank()
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @Assert\NotBlank()
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $openFrom;

	/**
	 * @Assert\NotBlank()
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $openTo;

	/**
	 * @Assert\NotBlank()
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $gps;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return self
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		if (!in_array($type, [
			self::TYPE_STOCK,
			self::TYPE_STORE,
		])) {
			throw new \InvalidArgumentException("Invalid status");
		}
		$this->type = $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @param Address $address
	 * @return self
	 */
	public function setAddress($address)
	{
		$this->address = $phone;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getOpenFrom()
	{
		return $this->openFrom;
	}

	/**
	 * @param string $openFrom
	 */
	public function setOpenFrom($openFrom)
	{
		$this->openFrom = $openFrom;
	}

	/**
	 * @return string
	 */
	public function getOpenTo()
	{
		return $this->openTo;
	}

	/**
	 * @param string $openTo
	 */
	public function setOpenTo($openTo)
	{
		$this->openTo = $openTo;
	}

	/**
	 * @return string
	 */
	public function getGps()
	{
		return $this->gps;
	}

	/**
	 * @param string $gps
	 */
	public function setGps($gps)
	{
		$this->gps = $gps;
	}
}