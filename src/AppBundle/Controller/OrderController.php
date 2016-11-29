<?php

namespace AppBundle\Controller;

use AppBundle\Facade\OrderFacade;
use AppBundle\Facade\UserFacade;
use AppBundle\Facade\WarehouseFacade;
use AppBundle\FormType\OrderFormType;
use AppBundle\FormType\VO\AddressVO;
use AppBundle\FormType\VO\OrderVO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

	/** @var WarehouseFacade */
	private $warehouseFacade;

	/** @var RouterInterface */
	private $router;

	/** @var FormFactory */
	private $formFactory;

	public function __construct(
		UserFacade $userFacade,
		OrderFacade $orderFacade,
		FormFactory $formFactory,
		WarehouseFacade $warehouseFacade,
		RouterInterface $router
	) {
		$this->userFacade = $userFacade;
		$this->orderFacade = $orderFacade;
		$this->formFactory = $formFactory;
		$this->warehouseFacade = $warehouseFacade;
		$this->router = $router;
	}

	/**
	 * @Route("/objednavka/", name="order_detail")
	 * @Template("order/detail.html.twig")
	 */
	public function actionDetail(Request $request)
	{
		$user = $this->userFacade->getUser();

		$addresses = [];
		foreach ($user->getAddresses() as $address) {
			$addresses[$address->getDescription()] = $address->getId();
		}

		$orderVO = new OrderVO();
		$orderVO->setDelivery(new AddressVO());

		$form = $this->formFactory->create(OrderFormType::class, $orderVO);
		$form->add('addressId', ChoiceType::class, [
			'label' => "Adresa",
			'choices' => $addresses + ['Jiná' => 0],
			"attr" => [
				"class" => "form-control",
			],
		]);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$order = $this->orderFacade->create($orderVO);

			return RedirectResponse::create($this->router->generate("order_thanks", ['id' => $order->getId()]));
		}

		return [
			"form" => $form->createView(),
			"user" => $user,
		];
	}

	/**
	 * @Route("/thanks/{id}", name="order_thanks")
	 * @Template("order/thanks.html.twig")
	 */
	public function actionThanks($id)
	{

		return [
			"user" => $this->userFacade->getUser(),
		];
	}

}
