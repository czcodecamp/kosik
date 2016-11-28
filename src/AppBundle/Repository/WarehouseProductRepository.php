<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;

/**
 * @author Vojta Bartoš <barvoj@seznam.cz>
 */
class WarehouseProductRepository extends EntityRepository
{
	/**
	 * @param Product|Product[] $product
	 * @return array
	 */
	public function getQuantityByProduct($product)
	{
		if (!is_array($product)) {
			$product = [$product];
		}

		$dql = 'SELECT p.id, SUM(wp.quantity) AS quantity 
			FROM AppBundle\Entity\WarehouseProduct wp
			JOIN AppBundle\Entity\Product p WITH wp.product = p
			WHERE wp.product IN (:products)
			GROUP BY p.id';

		$quantity = $this->getEntityManager()->createQuery($dql)
			->setParameter('products', $product)
			->getArrayResult();

		return $quantity;
	}
}