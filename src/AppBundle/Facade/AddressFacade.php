<?php

namespace AppBundle\Facade;

use AppBundle\Entity\Address;
use AppBundle\Repository\AddressRepository;
use Doctrine\ORM\EntityManager;

class AddressFacade
{
	private $entityManager;
	private $addressRepository;

	public function __construct(
		EntityManager $entityManager,
		AddressRepository $addressRepository
	) {
		$this->entityManager = $entityManager;
		$this->addressRepository = $addressRepository;
	}

	public function save(Address $address)
	{
		$this->entityManager->persist($address);
		$this->entityManager->flush([$address]);
	}
}