<?php
/**
 * Created by PhpStorm.
 * User: Barvoj
 * Date: 29.11.2016
 * Time: 22:13
 */

namespace AppBundle\FormType\VO;


use AppBundle\Entity\Address;

class AddressVO
{
	/**
	 * @var string
	 */
	private $firstName;

	/**
	 * @var string
	 */
	private $lastName;

	/**
	 * @var string
	 */
	private $street;

	/**
	 * @var string
	 */
	private $city;

	/**
	 * @var string
	 */
	private $postCode;

	/**
	 * @var string
	 */
	private $phone;

	/**
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 * @return AddressVO
	 */
	public function setFirstName(string $firstName)
	{
		$this->firstName = $firstName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 * @return AddressVO
	 */
	public function setLastName(string $lastName)
	{
		$this->lastName = $lastName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * @param string $street
	 * @return AddressVO
	 */
	public function setStreet(string $street)
	{
		$this->street = $street;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param string $city
	 * @return AddressVO
	 */
	public function setCity(string $city)
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPostCode()
	{
		return $this->postCode;
	}

	/**
	 * @param string $postCode
	 * @return AddressVO
	 */
	public function setPostCode(string $postCode)
	{
		$this->postCode = $postCode;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 * @return AddressVO
	 */
	public function setPhone(string $phone)
	{
		$this->phone = $phone;

		return $this;
	}

	public static function createFromAddress(Address $address)
	{
		$addressVO = new AddressVO();
		$addressVO
			->setFirstName($address->getFirstName())
			->setLastName($address->getLastName())
			->setStreet($address->getStreet())
			->setCity($address->getStreet())
			->setPostCode($address->getPostCode())
			->setPhone($address->getPhone());
		return $addressVO;
	}
}