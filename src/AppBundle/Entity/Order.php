<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 *
 * @ORM\Entity
 */
class Order
{

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
	 * @ORM\OneToOne(targetEntity="Cart", mappedBy="cart")
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
	 * @ORM\OneToOne(targetEntity="Address")
	 */
	private $deliveryAddress;

	/**
	 * @var Address
	 * @ORM\OneToOne(targetEntity="Address")
	 */
	private $invoiceAddress;

	/**
	 * @var string
	 */
	private $paymentType;

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

	/**
	 * @var string
	 * @ORM\Column(name="ipAddress", type="string", nullable=false)
	 */
	private $ipAddress;

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