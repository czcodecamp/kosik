<?php

namespace AppBundle\Facade;
use AppBundle\Entity\Cart;
use AppBundle\Entity\User;
use AppBundle\Repository\CartRepository;
use Doctrine\ORM\EntityManager;
use Sluggable\Fixture\Inheritance2\Car;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 */
class
CartFacade {

	/** @var CartRepository */
	private $cartRepository;

	/** @var EntityManager */
	private $entityManager;

	public function __construct(EntityManager $entityManager, CartRepository $cartRepository) {
		$this->entityManager = $entityManager;
		$this->cartRepository = $cartRepository;
	}

	public function createIfNotExists(User $user)
	{
		$cart = $this->getByUser($user);

		if ($cart === null) {
			$cart = new Cart();
			$cart->setUser($user);

			$this->save($cart);
		}

		return $cart;
	}

	/**
	 * @param User $user
	 * @return Cart
	 */
	public function getByUser(User $user) {
		return $this->cartRepository->findOneBy([
			"user" => $user,
			"status" => Cart::STATUS_NEW,
		]);
	}

	/**
	 * @param Cart $cart
	 */
	public function save(Cart $cart) {
		$this->entityManager->persist($cart);
		$this->entityManager->flush($cart);
	}
}