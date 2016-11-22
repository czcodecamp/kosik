<?php

namespace AppBundle\Facade;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartItem;
use AppBundle\FormType\VO\CartVO;
use AppBundle\Repository\CartItemRepository;
use Doctrine\ORM\EntityManager;

class CartItemFacade
{
	/** @var CartItemRepository */
	private $cartItemRepository;

	/** @var EntityManager */
	private $entityManager;

	/**
	 * @param CartItemRepository $cartItemRepository
	 * @param EntityManager $entityManager
	 */
	public function __construct(CartItemRepository $cartItemRepository, EntityManager $entityManager) {
		$this->cartItemRepository = $cartItemRepository;
		$this->entityManager = $entityManager;
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

	/**
	 * @param CartItem[] $cartItems
	 * @return int
	 */
	public function getTotalPrice(array $cartItems) {
		$totalPrice = 0;

		foreach ($cartItems as $cartItem) {
			$totalPrice += $cartItem->getTotalPrice();
		}

		return $totalPrice;
	}

	/**
	 * @param int $id
	 * @return CartItem|null
	 */
	public function find($id) {
		return $this->cartItemRepository->find($id);
	}

	/**
	 * @param CartItem $cartItem
	 */
	public function remove(CartItem $cartItem) {
		$this->entityManager->remove($cartItem);
		$this->entityManager->flush();
	}

	public function updateQuantities(CartVO $cartVO) {
		$cartItemsVO = $cartVO->getCartItems();

		foreach ($cartItemsVO as $cartItemVO) {
			$cartItem = $this->find($cartItemVO->getId());

			if ($cartItemVO->getQuantity() <= 0) {
				$this->remove($cartItem);
			} else {
				$cartItem->setQuantity($cartItemVO->getQuantity());
			}
		}

		$this->entityManager->flush();
	}
}