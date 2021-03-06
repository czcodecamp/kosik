<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 *
 * @ORM\Entity
 */
class Sale
{

	const TYPE_DELIVERY = 'delivery';
	const TYPE_PRICE = 'price';
	const TYPE_PERCENT = 'percent';

	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @Assert\NotBlank()
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $type;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $amount;


	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $percent;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
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
	 * @return Sale
	 */
	public function setType($type)
	{
		if (!in_array($type, [
			self::TYPE_DELIVERY,
			self::TYPE_PRICE,
			self::TYPE_PERCENT
		])) {
			throw new \InvalidArgumentException("Invalid status");
		}
		$this->type = $type;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @param int $amount
	 * @return Sale
	 */
	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPercent()
	{
		return $this->percent;
	}

	/**
	 * @param int $percent
	 * @return Sale
	 */
	public function setPercent($percent)
	{
		$this->percent = $percent;
		return $this;
	}
}