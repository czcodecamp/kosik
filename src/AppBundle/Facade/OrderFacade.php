<?php

namespace AppBundle\Facade;
use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use AppBundle\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 */
class OrderFacade {

	/** @var OrderRepository */
	private $orderRepository;

	/** @var EntityManager */
	private $entityManager;

	public function __construct(EntityManager $entityManager, OrderRepository $orderRepository) {
		$this->entityManager = $entityManager;
		$this->orderRepository = $orderRepository;
	}

	public function createIfNotExists(User $user)
	{
		$order = $this->getByUser($user);

		if ($order === null) {
			$order = new Order();
			$order->setUser($user);
			$this->save($order);
		}

		return $order;
	}

	/**
	 * @param User $user
	 * @return Order
	 */
	public function getByUser(User $user) {
		return $this->orderRepository->findOneBy([
			"user" => $user,
		]);
	}

	/**
	 * @param Order $order
	 */
	public function save(Order $order) {
		$this->entityManager->persist($order);
		$this->entityManager->flush($order);
	}
}