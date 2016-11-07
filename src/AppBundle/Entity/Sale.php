<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SaleRepository")
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
	 */
	public function setPercent($percent)
	{
		$this->percent = $percent;
		return $this;
	}
}