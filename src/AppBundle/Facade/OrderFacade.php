<?php

namespace AppBundle\Facade;
use AppBundle\Entity\Address;
use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use AppBundle\FormType\VO\OrderVO;
use AppBundle\Repository\OrderRepository;
use AppBundle\Repository\WarehouseRepository;
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

	/** @var AddressFacade */
	private $addressFacade;

	/** @var WarehouseRepository */
	private $warehouseRepository;

	/** @var UserFacade */
	private $userFacade;

	/** @var CartFacade */
	private $cartFacade;

	public function __construct(
		EntityManager $entityManager,
		OrderRepository $orderRepository,
		AddressFacade $addressFacade,
		WarehouseRepository $warehouseRepository,
		UserFacade $userFacade,
		CartFacade $cartFacade
	) {
		$this->entityManager = $entityManager;
		$this->orderRepository = $orderRepository;
		$this->addressFacade = $addressFacade;
		$this->warehouseRepository = $warehouseRepository;
		$this->userFacade = $userFacade;
		$this->cartFacade = $cartFacade;
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
	 * @param OrderVO $orderVO
	 * @return Order
	 */
	public function create(OrderVO $orderVO)
	{
		$user = $this->userFacade->getUser();

		$order = new Order();
		$order->setCart($this->cartFacade->getByUser($user));
		$order->setUser($user);
		$order->setDeliveryType($orderVO->getDeliveryType());
		$order->setPaymentType($orderVO->getPaymentType());

		if ($orderVO->getDeliveryType() === Order::DELIVERY_TYPE_SHOP) {
			$warehouse = $this->warehouseRepository->find($orderVO->getWarehouse());

			$order->setDeliveryWarehouse($warehouse);
		} else {
			$addressVO = $orderVO->getDelivery();

			$address = new Address();
			$address->setFirstName($addressVO->getFirstName());
			$address->setLastName($addressVO->getLastName());
			$address->setStreet($addressVO->getStreet());
			$address->setCity($addressVO->getCity());
			$address->setPostCode($addressVO->getPostCode());
			$address->setPhone($addressVO->getPhone());


			$this->addressFacade->save($address);

			$order->setDeliveryAddress($address);
		}

		$this->save($order);

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