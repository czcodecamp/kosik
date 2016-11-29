<?php

namespace AppBundle\Facade;

use AppBundle\Entity\Category;
use AppBundle\Repository\ProductRepository;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 */
class ProductFacade {

	private $productRepository;

	public function __construct(ProductRepository $productRepository) {
		$this->productRepository = $productRepository;
	}

	public function findByCategory(Category $category, $limit, $offset) {
		return $this->productRepository->findByCategory($category)
			->setFirstResult($offset)
			->setMaxResults($limit)
			->getQuery()->getResult();
	}

	public function getCountByCategory(Category $category) {
		return $this->productRepository->findByCategory($category)
			->select('COUNT(p.id)')
			->getQuery()->getSingleScalarResult();
	}

	public function getBySlug($slug) {
		return $this->productRepository->findOneBy([
			"slug" => $slug,
		]);
	}

	/**
	 * @param int $id
	 * @return Product|null
	 */
	public function find($id) {
		return $this->productRepository->find($id);
	}

	public function getAll($limit, $offset) {
		return $this->productRepository->findBy(
			[],
			[
				"rank" => "desc"
			],
			$limit,
			$offset
		);
	}

	public function countAllProducts() {
		return $this->productRepository->countAll();
	}


}