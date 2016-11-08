<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartItemRepository")
 */
class CartItem
{

	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @var Cart
	 * @ORM\ManyToOne(targetEntity="Cart")
	 */
	private $cart;

	/**
	 * @var Product
	 * @ORM\ManyToOne(targetEntity="Product")
	 */
	private $product;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $quantity;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $pricePerItem;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return Cart
	 */
	public function getCart()
	{
		return $this->cart;
	}

	/**
	 * @param Cart $cart
	 * @return self
	 */
	public function setCart($cart)
	{
		$this->cart = $cart;
		return $this;
	}

	/**
	 * @return Product
	 */
	public function getProduct()
	{
		return $this->product;
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

	/**
	 * @return int
	 */
	public function getPricePerItem()
	{
		return $this->pricePerItem;
	}

	/**
	 * @param int $pricePerItem
	 * @return self
	 */
	public function setPricePerItem($pricePerItem)
	{
		$this->pricePerItem = $pricePerItem;
		return $this;
	}
}