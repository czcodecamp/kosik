<?php
namespace AppBundle\Service;

use AppBundle\Facade\UserFacade;
use AppBundle\Facade\CartFacade;
use AppBundle\Facade\CartItemFacade;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 */
class Cart {
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
	)
	{
		$this->userFacade = $userFacade;
		$this->cartFacade = $cartFacade;
		$this->cartItemFacade = $cartItemFacade;
	}

	public function create($template)
	{
		$user = $this->userFacade->getUser();

		if($user){
			$cart = $this->cartFacade->createIfNotExists($user);
			$cartItems = $this->cartItemFacade->findByCart($cart);
			$totalPrice = $this->cartItemFacade->getTotalPrice($cartItems);

			if(!isset($template['user'])){
				$template['user'] = $user;
			}
			$template['cartItems'] = $cartItems;
			$template['totalPrice'] = $totalPrice;

		}

		return $template;
	}
}