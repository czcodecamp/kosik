<?php
namespace AppBundle\Controller;

use AppBundle\Facade\ProductFacade;
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
	private $formFactory;
	private $router;

	public function __construct(
		ProductFacade $productFacade,
		FormFactory $formFactory,
		RouterInterface $router
	)
	{
		$this->productFacade = $productFacade;
		$this->formFactory = $formFactory;
		$this->router = $router;
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

		$form = $this->formFactory->create(CartAddFormType::class, []);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

			return RedirectResponse::create($this->router->generate("cart_detail"));
		}

		return [
			"product" => $product,
			"form" => $form->createView(),
		];
	}

}
