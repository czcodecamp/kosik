<?php

namespace AppBundle\FormType\VO;

class OrderVO
{
	/**
	 * @var string
	 */
	private $deliveryType;

	/**
	 * @var string
	 */
	private $paymentType;

	/**
	 * @var int
	 */
	private $warehouse;

	/**
	 * @var AddressVO
	 */
	private $invoice;

	/**
	 * @var AddressVO
	 */
	private $delivery;

	/**
	 * @return string
	 */
	public function getDeliveryType()
	{
		return $this->deliveryType;
	}

	/**
	 * @param string $deliveryType
	 */
	public function setDeliveryType(string $deliveryType)
	{
		$this->deliveryType = $deliveryType;
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
	 */
	public function setPaymentType(string $paymentType)
	{
		$this->paymentType = $paymentType;
	}

	/**
	 * @return int
	 */
	public function getWarehouse()
	{
		return $this->warehouse;
	}

	/**
	 * @param int $warehouse
	 */
	public function setWarehouse(int $warehouse)
	{
		$this->warehouse = $warehouse;
	}

	/**
	 * @return AddressVO
	 */
	public function getInvoice()
	{
		return $this->invoice;
	}

	/**
	 * @param AddressVO $invoice
	 */
	public function setInvoice(AddressVO $invoice)
	{
		$this->invoice = $invoice;
	}

	/**
	 * @return AddressVO
	 */
	public function getDelivery()
	{
		return $this->delivery;
	}

	/**
	 * @param AddressVO $delivery
	 */
	public function setDelivery(AddressVO $delivery)
	{
		$this->delivery = $delivery;
	}
}