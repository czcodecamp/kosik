<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 *
 * @ORM\Table(name="`order`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
{
	const DELIVERY_TYPE_SHOP = 'shop';
	const DELIVERY_TYPE_POST = 'post';

	const PAYMENT_TYPE_CASH = 'cash';
	const PAYMENT_TYPE_CARD = 'card';
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @Assert\NotBlank()
	 * @var Cart
	 * @ORM\ManyToOne(targetEntity="Cart")
	 */
	private $cart;

	/**
	 * @Assert\NotBlank()
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User")
	 */
	private $user;

	/**
	 * @var Address
	 * @ORM\ManyToOne(targetEntity="Address")
	 * @ORM\JoinColumn(name="delivery_address_id", referencedColumnName="id", nullable=true)
	 */
	private $deliveryAddress;

	/**
	 * @var Address
	 * @ORM\ManyToOne(targetEntity="Address")
	 * @ORM\JoinColumn(name="invoice_address_id", referencedColumnName="id", nullable=true)
	 */
	private $invoiceAddress;

	/**
	 * @var string
	 * @ORM\Column(name="payment_type")
	 */
	private $paymentType;

	/**
	 * @var string
	 * @ORM\Column(name="delivery_type")
	 */
	private $deliveryType;

	/**
	 * @var Warehouse
	 * @ORM\ManyToOne(targetEntity="Warehouse")
	 * @ORM\JoinColumn(name="delivery_warehouse_id", referencedColumnName="id", nullable=true)
	 */
	private $deliveryWarehouse;

	/**
	 * @var Sale
	 * @ORM\ManyToOne(targetEntity="Sale")
	 */
	private $sale;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="created", type="datetime", nullable=false)
	 */
	private $created;

	public function __construct()
	{
		$this->created = new \DateTime();
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return self
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPaymentType()
	{
		return $this->paymentType;
	}

	/**
	 * @param string $paymentType
	 * @return self
	 */
	public function setPaymentType($paymentType)
	{
		$this->paymentType = $paymentType;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDeliveryType()
	{
		return $this->deliveryType;
	}

	/**
	 * @param string $deliveryType
	 * @return self
	 */
	public function setDeliveryType($deliveryType)
	{
		$this->deliveryType = $deliveryType;
		return $this;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param User $user
	 * @return self
	 */
	public function setUser($user)
	{
		$this->user = $user;
		return $this;
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
	 * @return Sale
	 */
	public function getSale()
	{
		return $this->sale;
	}

	/**
	 * @param Sale $sale
	 * @return self
	 */
	public function setSale($sale)
	{
		$this->sale = $sale;
		return $this;
	}

	/**
	 * @return Address
	 */
	public function getDeliveryAddress()
	{
		return $this->deliveryAddress;
	}

	/**
	 * @param Address $deliveryAddress
	 * @return self
	 */
	public function setDeliveryAddress($deliveryAddress)
	{
		$this->deliveryAddress = $deliveryAddress;
		return $this;
	}

	/**
	 * @return Address
	 */
	public function getInvoiceAddress()
	{
		return $this->invoiceAddress;
	}

	/**
	 * @param Address $invoiceAddress
	 * @return self
	 */
	public function setInvoiceAddress($invoiceAddress)
	{
		$this->invoiceAddress = $invoiceAddress;
		return $this;
	}

	/**
	 * @param Warehouse $deliveryWarehouse
	 * @return Order
	 */
	public function setDeliveryWarehouse(Warehouse $deliveryWarehouse): Order
	{
		$this->deliveryWarehouse = $deliveryWarehouse;

		return $this;
	}

	/**
	 * @return Warehouse
	 */
	public function getDeliveryWarehouse()
	{
		return $this->deliveryWarehouse;
	}

	/**
	 * @return string
	 */
	public function getIpAddress()
	{
		return $this->ipAddress;
	}

	/**
	 * @param string $ipAddress
	 * @return self
	 */
	public function setIpAddress($ipAddress)
	{
		$this->ipAddress = $ipAddress;
		return $this;
	}
}