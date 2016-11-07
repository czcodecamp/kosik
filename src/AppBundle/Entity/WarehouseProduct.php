<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WarehouseProductRepository")
 */
class WarehouseProduct
{

	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @var Product
	 * @ORM\ManyToOne(targetEntity="Product")
	 */
	private $product;

	/**
	 * @var Warehouse
	 * @ORM\OneToMany(targetEntity="Warehouse")
	 */
	private $warehouse;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $quantity;


	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $expectedArrival;

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
	 * @return Product
	 */
	public function getProduct()
	{
		return $this->cart;
	}

	/**
	 * @param Product $product
	 * @return self
	 */
	public function setProduct($product)
	{
		$this->product = $product;
		return $this;
	}

	/**
	 * @return Warehouse
	 */
	public function getWarehouse()
	{
		return $this->warehouse;
	}

	/**
	 * @param Warehouse $warehouse
	 * @return self
	 */
	public function setWarehouse($warehouse)
	{
		$this->product = $warehouse;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getExpectedArrival()
	{
		return $this->expectedArrival;
	}

	/**
	 * @param int $expectedArrival
	 * @return self
	 */
	public function setExpectedArrival($expectedArrival)
	{
		$this->expectedArrival = $expectedArrival;
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