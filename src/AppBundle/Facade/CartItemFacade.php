<?php

namespace AppBundle\Facade;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartItem;
use AppBundle\Entity\Product;
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
	 * @param Cart $cart
	 * @param Product $product
	 * @return CartItem
	 */
	public function add(Cart $cart, Product $product) {
		$cartItem = $this->cartItemRepository->findOneBy([
			"cart" => $cart,
			"product" => $product,
		]);

		if (!$cartItem) {
			$cartItem = new CartItem();
			$cartItem->setPricePerItem($product->getPrice());
			$cartItem->setProduct($product);
			$cartItem->setCart($cart);
		}

		$quantity = $cartItem->getQuantity()+1;
		$cartItem->setQuantity($quantity);
		$this->save($cartItem);
	}

	/**
	 * @param CartItem $cartItem
	 */
	public function remove(CartItem $cartItem) {
		$this->entityManager->remove($cartItem);
		$this->entityManager->flush();
	}

	/**
	 * @param CartItem $cartItem
	 */
	public function save(CartItem $cartItem) {
		$this->entityManager->persist($cartItem);
		$this->entityManager->flush($cartItem);
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