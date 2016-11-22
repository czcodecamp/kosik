<?php

namespace AppBundle\FormType\VO;

use AppBundle\Entity\CartItem;

class CartItemVO
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var int
	 */
	private $quantity;

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return CartItemVO
	 */
	public function setId(int $id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 * @return CartItemVO
	 */
	public function setQuantity(int $quantity)
	{
		$this->quantity = $quantity;

		return $this;
	}

	public static function createFromCartItem(CartItem $cartItem)
	{
		$settings = new CartItemVO();
		$settings->setId($cartItem->getId())
			->setQuantity($cartItem->getQuantity());
		return $settings;
	}
}