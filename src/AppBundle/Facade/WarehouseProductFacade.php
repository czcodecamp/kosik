<?php

namespace AppBundle\Facade;

use AppBundle\Entity\Product;
use AppBundle\Entity\Warehouse;
use AppBundle\Entity\WarehouseProduct;
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

	/**
	 * @param Product $product
	 * @param Warehouse $warehouse
	 * @return WarehouseProduct
	 */
	public function findByProductAndWarehouse(Product $product, Warehouse $warehouse) {
		return $this->warehouseProductRepository->findOneBy([
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