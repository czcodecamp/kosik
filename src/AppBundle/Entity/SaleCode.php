<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 *
 * @ORM\Entity
 */
class SaleCode
{

	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @var Sale
	 * @ORM\ManyToOne(targetEntity="Sale")
	 */
	private $sale;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $code;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $quantity;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return Sale
	 */
	public function getSale(): Sale
	{
		return $this->sale;
	}

	/**
	 * @param Sale $sale
	 */
	public function setSale(Sale $sale)
	{
		$this->sale = $sale;
	}

	/**
	 * @return string
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * @param string $code
	 * @return self
	 */
	public function setCode($code)
	{
		$this->code = $code;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 * @return self
	 */
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
		return $this;
	}
}