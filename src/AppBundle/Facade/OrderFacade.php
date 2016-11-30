<?php

namespace AppBundle\Facade;
use AppBundle\Entity\Address;
use AppBundle\Entity\Cart;
use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use AppBundle\FormType\VO\OrderVO;
use AppBundle\Repository\AddressRepository;
use AppBundle\Repository\OrderRepository;
use AppBundle\Repository\WarehouseRepository;
use Doctrine\ORM\EntityManager;
use Swift_Message;
use Swift_Mailer;

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

	/** @var AddressRepository */
	private $addressRepository;

	/** @var CartItemFacade */
	private $cartItemFacade;

	/** @var  Swift_Mailer */
	private $swiftMailer;

	public function __construct(
		EntityManager $entityManager,
		OrderRepository $orderRepository,
		AddressFacade $addressFacade,
		WarehouseRepository $warehouseRepository,
		UserFacade $userFacade,
		CartFacade $cartFacade,
		AddressRepository $addressRepository,
		CartItemFacade $cartItemFacade,
		Swift_Mailer $swiftMailer
	) {
		$this->entityManager = $entityManager;
		$this->orderRepository = $orderRepository;
		$this->addressFacade = $addressFacade;
		$this->warehouseRepository = $warehouseRepository;
		$this->userFacade = $userFacade;
		$this->cartFacade = $cartFacade;
		$this->addressRepository = $addressRepository;
		$this->cartItemFacade = $cartItemFacade;
		$this->swiftMailer = $swiftMailer;
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
		$cart = $this->cartFacade->getByUser($user);
		$cart->setStatus(Cart::STATUS_ORDERED);

		$order = new Order();
		$order->setCart($cart);
		$order->setUser($user);
		$order->setDeliveryType($orderVO->getDeliveryType());
		$order->setPaymentType($orderVO->getPaymentType());

		if ($orderVO->getDeliveryType() === Order::DELIVERY_TYPE_SHOP) {
			$warehouse = $this->warehouseRepository->find($orderVO->getWarehouse());

			$order->setDeliveryWarehouse($warehouse);
		} else {
			if ($orderVO->getAddressId() === 0) {
				$addressVO = $orderVO->getDelivery();

				$address = new Address();
				$address->setUser($user);
				$address->setFirstName($addressVO->getFirstName());
				$address->setLastName($addressVO->getLastName());
				$address->setStreet($addressVO->getStreet());
				$address->setCity($addressVO->getCity());
				$address->setPostCode($addressVO->getPostCode());
				$address->setPhone($addressVO->getPhone());

				$order->setDeliveryAddress($address);
			} else {
				$address = $this->addressRepository->find($orderVO->getAddressId());

				$order->setDeliveryAddress($address);
			}
		}

		if ($order->getDeliveryAddress() !== null) {
			$this->entityManager->persist($order->getDeliveryAddress());
			$this->entityManager->flush($order->getDeliveryAddress());
		}

		$this->entityManager->persist($order);
		$this->entityManager->flush($order);

		$this->entityManager->flush($cart);

		$this->save($order);

		return $order;
	}

	public function sendOrderEmail($order)
	{
		$cart = $order->getCart();
		$subject = "CodeCamp - Nová objednávka č.: " . $order->getId();
		$from = 'kosik@codecamp.cz';
		$to = $order->getUser()->getEmail();

		$text = "Děkujeme, přijali jsme Vaši objednávku číslo: "
			. $order->getId()
			. "\n\r";
		$text .= " Objednali jste: ". "\n\r";

		$cartItems = $this->cartItemFacade->findByCart($cart);
		foreach($cartItems as $item){
			$text .= " - ".$item->getProduct()->getTitle();
			$text .= " ( ". $item->getQuantity() ." ks";
			$text .= " - ". number_format($item->getPricePerItem(),0,","," ") .",- Kč )";
			$text .= "\n\r";
		}

		$totalPrice = $this->cartItemFacade->getTotalPrice($cartItems);
		$text .= "Celková cena je: " . number_format($totalPrice,0,","," ") . ",- Kč";

		$message = Swift_Message::newInstance()
			->setSubject($subject)
			->setFrom($from)
			->setTo($to)
			->setBody($text);

		$this->swiftMailer->send($message);
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