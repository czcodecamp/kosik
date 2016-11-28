<?php

namespace AppBundle\Controller;

use AppBundle\Facade\ProductFacade;
use AppBundle\Facade\WarehouseProductFacade;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 * @Route(service="app.controller.product_controller")
 */
class ProductController
{
	private $productFacade;
	private $warehouseProductFacade;

	public function __construct(ProductFacade $productFacade, WarehouseProductFacade $warehouseProductFacade)
	{
		$this->productFacade = $productFacade;
		$this->warehouseProductFacade = $warehouseProductFacade;
	}
	/**
	 * @Route("/product/{slug}", name="product_detail")
	 * @Template("product/detail.html.twig")
	 */
	public function productDetailAction($slug)
	{
		$product = $this->productFacade->getBySlug($slug);
		if (!$product) {
			throw new NotFoundHttpException("Produkt neexistuje");
		}

		$warehouseProducts = $this->warehouseProductFacade->findByProduct($product);

		$quantity = $this->warehouseProductFacade->getQuantityByProduct($product);

		return [
			"product" => $product,
			"warehouseProducts" => $warehouseProducts,
		];
	}

}
