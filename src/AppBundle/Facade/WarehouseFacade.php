<?php

namespace AppBundle\Facade;

use AppBundle\Entity\Warehouse;
use AppBundle\Repository\WarehouseRepository;

class WarehouseFacade
{
	/** @var WarehouseRepository */
	private $warehouseRepository;

	/**
	 * @param WarehouseRepository $warehouseRepository
	 */
	public function __construct(WarehouseRepository $warehouseRepository)
	{
		$this->warehouseRepository = $warehouseRepository;
	}

	/**
	 * @return array
	 */
	public function findByProduct() {
		return $this->warehouseRepository->findBy([
			"type" => Warehouse::TYPE_STORE,
		]);
	}
}