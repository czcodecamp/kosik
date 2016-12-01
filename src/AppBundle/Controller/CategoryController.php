<?php

namespace AppBundle\Controller;

use AppBundle\Service\Cart;
use AppBundle\Facade\CategoryFacade;
use AppBundle\Facade\ProductFacade;
use AppBundle\Facade\WarehouseProductFacade;
use AppBundle\Service\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 * @Route(service="app.controller.category_controller")
 */
class CategoryController
{
	private $categoryFacade;
	private $productFacade;
	private $warehouseProductFacade;

	/** @var Cart */
	private $cartService;

	public function __construct(
		CategoryFacade $categoryFacade,
		ProductFacade $productFacade,
		WarehouseProductFacade $warehouseProductFacade,
		Cart $cartService
	) {

		$this->categoryFacade = $categoryFacade;
		$this->productFacade = $productFacade;
		$this->warehouseProductFacade = $warehouseProductFacade;
		$this->cartService = $cartService;
	}
	/**
	 * @Route("/vyber/{slug}/{page}", name="category_detail", requirements={"page": "\d+"}, defaults={"page": 1})
	 * @Template("category/detail.html.twig")
	 */
	public function categoryDetail($slug, $page)
	{
		$category = $this->categoryFacade->getBySlug($slug);

		if (!$category) {
			throw new NotFoundHttpException("Kategorie neexistuje");
		}

		$countByCategory = $this->productFacade->getCountByCategory($category);

		$paginator = new Paginator($countByCategory, 6);
		$paginator->setCurrentPage($page);
		$products = $this->productFacade->findByCategory($category, $paginator->getLimit(), $paginator->getOffset());
		$stockCounts = $this->warehouseProductFacade->getQuantityByProduct($products);

		$template = [
			"products" => $products,
			"categories" => $this->categoryFacade->getParentCategories($category),
			"category" => $category,
			"currentPage" => $page,
			"totalPages" => $paginator->getTotalPageCount(),
			"pageRange" => $paginator->getPageRange(5),
			"stockCounts" => $stockCounts,
		];

		$template = $this->cartService->create($template);

		return $template;
	}

}
