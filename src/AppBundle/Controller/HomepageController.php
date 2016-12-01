<?php
namespace AppBundle\Controller;

use AppBundle\Service\Cart;
use AppBundle\Facade\CategoryFacade;
use AppBundle\Facade\ProductFacade;
use AppBundle\Facade\UserFacade;
use AppBundle\Facade\WarehouseProductFacade;
use AppBundle\Service\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 * @Route(service="app.controller.homepage_controller")
 */
class HomepageController
{

	private $productFacade;
	private $categoryFacade;
	private $userFacade;
	private $warehouseProductFacade;

	/** @var Cart */
	private $cartService;

	public function __construct(
		ProductFacade $productFacade,
		CategoryFacade $categoryFacade,
		UserFacade $userFacade,
		WarehouseProductFacade $warehouseProductFacade,
		Cart $cartService
	) {

		$this->productFacade = $productFacade;
		$this->categoryFacade = $categoryFacade;
		$this->userFacade = $userFacade;
		$this->warehouseProductFacade = $warehouseProductFacade;
		$this->cartService = $cartService;
	}

	/**
	 * @Route("/", name="homepage")
	 * @Template("homepage/homepage.html.twig")
	 */
	public function homepageAction(Request $request)
	{
		$page = intval($request->get('page', 1));
		$count = $this->productFacade->countAllProducts();
		$paginator = new Paginator($count, 6);
		$paginator->setCurrentPage($page);
		$products = $this->productFacade->getAll($paginator->getLimit(), $paginator->getOffset());
		$stockCounts = $this->warehouseProductFacade->getQuantityByProduct($products);

		$template = [
			"products" => $products,
			"categories" => $this->categoryFacade->getTopLevelCategories(),
			"currentPage" => $page,
			"totalPages" => $paginator->getTotalPageCount(),
			"pageRange" => $paginator->getPageRange(5),
			"user" => $this->userFacade->getUser(),
			"stockCounts" => $stockCounts
		];

		$template = $this->cartService->create($template);

		return $template;
	}

}
