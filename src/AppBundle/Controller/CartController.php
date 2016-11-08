<?php

namespace AppBundle\Controller;

use AppBundle\Facade\CartFacade;
use AppBundle\Facade\CartItemFacade;
use AppBundle\Facade\UserFacade;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

	/** @var CartItemFacade */
	private $cartItemFacade;

	public function __construct(
		UserFacade $userFacade,
		CartFacade $cartFacade,
		CartItemFacade $cartItemFacade
	) {

		$this->userFacade = $userFacade;
		$this->cartFacade = $cartFacade;
		$this->cartItemFacade = $cartItemFacade;
	}

	/**
	 * @Route("/kosik", name="cart_detail")
	 * @Template("cart/detail.html.twig")
	 */
	public function actionDetail()
	{
		$user = $this->userFacade->getUser();
		$cart = $this->cartFacade->createIfNotExists($user);
		$items = $this->cartItemFacade->findByCart($cart);

		return [
			'cartItems' => $items,
		];
	}

}
