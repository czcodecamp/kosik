<?php

namespace AppBundle\FormType\VO;

class CartVO
{
	private $cartItems;

	/**
	 * @return CartItemVO[]
	 */
	public function getCartItems()
	{
		return $this->cartItems;
	}

	/**
	 * @param CartItemVO[] $cartItems
	 */
	public function setCartItems($cartItems)
	{
		$this->cartItems = $cartItems;
	}
}