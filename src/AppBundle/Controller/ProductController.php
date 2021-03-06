<?php
namespace AppBundle\Controller;

use AppBundle\Service\Cart;
use AppBundle\Facade\ProductFacade;
use AppBundle\Facade\WarehouseProductFacade;
use AppBundle\FormType\CartAddFormType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;


/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 * @Route(service="app.controller.product_controller")
 */
class ProductController
{
	private $productFacade;
	private $warehouseProductFacade;
	private $formFactory;
	private $router;

	/** @var Cart */
	private $cartService;

	public function __construct(
		ProductFacade $productFacade,
		WarehouseProductFacade $warehouseProductFacade,
		FormFactory $formFactory,
		RouterInterface $router,
		Cart $cartService
	)
	{
		$this->productFacade = $productFacade;
		$this->warehouseProductFacade = $warehouseProductFacade;
		$this->formFactory = $formFactory;
		$this->router = $router;
		$this->cartService = $cartService;
	}
	/**
	 * @Route("/product/{slug}", name="product_detail")
	 * @Template("product/detail.html.twig")
	 *
	 * @param Request $request
	 * @return RedirectResponse|array
	 */
	public function productDetailAction(Request $request, $slug)
	{
		$product = $this->productFacade->getBySlug($slug);
		if (!$product) {
			throw new NotFoundHttpException("Produkt neexistuje");
		}

		$warehouseProducts = $this->warehouseProductFacade->findByProduct($product);

		$quantity = $this->warehouseProductFacade->getQuantityByProduct($product);

		$form = $this->formFactory->create(CartAddFormType::class, []);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$item = [
				"id" => $product->getId(),
				"quantity" => $form->get("quantity")->getData(),
			];

			return RedirectResponse::create($this->router->generate("cart_add_item", $item));
		}

		$template = [
			"product" => $product,
			"warehouseProducts" => $warehouseProducts,
			"form" => $form->createView(),
		];

		$template = $this->cartService->create($template);

		return $template;
	}

}
