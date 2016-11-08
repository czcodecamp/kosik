<?php

namespace AppBundle\Facade;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartItem;
use AppBundle\Repository\CartItemRepository;

class CartItemFacade
{
	/** @var CartItemRepository */
	private $cartItemRepository;

	public function __construct(CartItemRepository $cartItemRepository) {
		$this->cartItemRepository = $cartItemRepository;
	}

	/**
	 * @param Cart $cart
	 * @return CartItem[]
	 */
	public function findByCart(Cart $cart) {
		return $this->cartItemRepository->findBy([
			"cart" => $cart,
		]);
	}
}