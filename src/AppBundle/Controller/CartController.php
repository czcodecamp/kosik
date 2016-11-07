<?php

namespace AppBundle\Controller;

use AppBundle\Facade\CartFacade;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 * @Route(service="app.controller.category_controller")
 */
class CartController
{
	private $cartFacade;

	public function __construct(
		CartFacade $cartFacade
	) {

		$this->cartFacade = $cartFacade;
	}

	/**
	 * @Route("/kosik", name="cart_detail")
	 * @Template("cart/detail.html.twig")
	 */
	public function actionDetail()
	{
		return [];
	}

}
