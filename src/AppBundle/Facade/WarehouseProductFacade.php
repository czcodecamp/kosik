<?php

namespace AppBundle\Facade;

use AppBundle\Entity\Product;
use AppBundle\Entity\Warehouse;
use AppBundle\Repository\WarehouseProductRepository;

class WarehouseProductFacade
{
	/** @var WarehouseProductRepository */
	private $warehouseProductRepository;

	public function __construct(WarehouseProductRepository $warehouseProductRepository) {
		$this->warehouseProductRepository = $warehouseProductRepository;
	}

	public function findByProduct(Product $product) {
		return $this->warehouseProductRepository->findBy([
			"product" => $product,
		]);
	}

	public function findByProductAndWarehouse(Product $product, Warehouse $warehouse) {
		return $this->warehouseProductRepository->findBy([
			"product" => $product,
			"warehouse" => $warehouse,
		]);
	}

	/**
	 * @param Product|Product[] $product
	 * @return array
	 */
	public function getQuantityByProduct($product)
	{
		$rows = $this->warehouseProductRepository->getQuantityByProduct($product);

		$quantities = [];

		foreach($rows as $row) {
			$quantities[$row['id']] = $row['quantity'];
		}

		return $quantities;
	}
}