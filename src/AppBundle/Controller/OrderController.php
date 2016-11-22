<?php

namespace AppBundle\Controller;

use AppBundle\Facade\OrderFacade;
use AppBundle\Facade\UserFacade;
use AppBundle\FormType\OrderFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 * @Route(service="app.controller.order_controller")
 */
class OrderController
{
	/** @var UserFacade */
	private $userFacade;

	/** @var OrderFacade */
	private $orderFacade;

	/** @var RouterInterface */
	private $router;

	/** @var FormFactory */
	private $formFactory;

	public function __construct(
		UserFacade $userFacade,
		OrderFacade $orderFacade,
		FormFactory $formFactory,
		RouterInterface $router
	) {
		$this->userFacade = $userFacade;
		$this->orderFacade = $orderFacade;
		$this->formFactory = $formFactory;
		$this->router = $router;
	}

	/**
	 * @Route("/objednavka/", name="order_detail")
	 * @Template("order/detail.html.twig")
	 */
	public function actionDetail(Request $request)
	{


		$form = $this->formFactory->create(OrderFormType::class, []);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			return RedirectResponse::create($this->router->generate("cart_detail"));
		}

		return [
			"form" => $form->createView(),
			"user" => $this->userFacade->getUser(),
		];
	}

}
