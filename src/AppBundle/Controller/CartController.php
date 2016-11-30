<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CartItem;
use AppBundle\Facade\CartFacade;
use AppBundle\Facade\ProductFacade;
use AppBundle\Facade\CartItemFacade;
use AppBundle\Facade\UserFacade;
use AppBundle\FormType\CartFormType;
use AppBundle\FormType\VO\CartItemVO;
use AppBundle\FormType\VO\CartVO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 * @Route(service="app.controller.cart_controller")
 */
class CartController
{
	/** @var UserFacade */
	private $userFacade;

	/** @var CartFacade */
	private $cartFacade;

	/** @var ProductFacade */
	private $productFacade;

	/** @var CartItemFacade */
	private $cartItemFacade;

	/** @var RouterInterface */
	private $router;

	/** @var FormFactory */
	private $formFactory;

	public function __construct(
		UserFacade $userFacade,
		CartFacade $cartFacade,
		CartItemFacade $cartItemFacade,
		ProductFacade $productFacade,
		FormFactory $formFactory,
		RouterInterface $router
	) {

		$this->userFacade = $userFacade;
		$this->cartFacade = $cartFacade;
		$this->cartItemFacade = $cartItemFacade;
		$this->productFacade = $productFacade;
		$this->formFactory = $formFactory;
		$this->router = $router;
	}

	/**
	 * @Route("/kosik/", name="cart_detail")
	 * @Template("cart/detail.html.twig")
	 */
	public function actionDetail(Request $request)
	{
		$user = $this->userFacade->getUser();
		$cart = $this->cartFacade->createIfNotExists($user);
		$cartItems = $this->cartItemFacade->findByCart($cart);
		$totalPrice = $this->cartItemFacade->getTotalPrice($cartItems);

		$cartItemsVO = [];
		foreach ($cartItems as $cartItem) {
			$cartItemsVO[] = CartItemVO::createFromCartItem($cartItem);
		}
		$cartVO = new CartVO();
		$cartVO->setCartItems($cartItemsVO);

		$form = $this->formFactory->create(CartFormType::class, $cartVO);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->cartItemFacade->updateQuantities($cartVO);

			return RedirectResponse::create($this->router->generate("cart_detail"));
		}

		return [
			"form" => $form->createView(),
			'totalPrice' => $totalPrice,
			'cartItems' => $cartItems,
			"user" => $this->userFacade->getUser(),
		];
	}
	/**
	 * @Route("/kosik/remove/{id}", name="cart_remove_item", requirements={"id": "\d+"})
	 * @Template("cart/detail.html.twig")
	 */
	public function actionRemoveItem($id)
	{
		$cartItem = $this->cartItemFacade->find($id);

		if ($cartItem === null) {
			throw new NotFoundHttpException("Položka nebyla nalezena");
		}

		$this->cartItemFacade->remove($cartItem);

		return RedirectResponse::create($this->router->generate("cart_detail"));
	}

	/**
	 * @Route("/kosik/add/{id}/{quantity}", name="cart_add_item", requirements={"id": "\d+", "quantity": "\d+"})
	 */
	public function actionAddItem($id, $quantity = 1)
	{
		$product = $this->productFacade->find($id);
		if (!$product) {
			throw new NotFoundHttpException("Produkt neexistuje");
		}

		$user = $this->userFacade->getUser();
		$cart = $this->cartFacade->createIfNotExists($user);

		$this->cartItemFacade->add($cart, $product, $quantity);

		return RedirectResponse::create($this->router->generate("cart_detail"));
	}
}
