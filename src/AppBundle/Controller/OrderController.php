<?php
namespace AppBundle\Controller;

use AppBundle\Facade\CartItemFacade;
use AppBundle\Service\Cart;
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
use Swift_Message;
use Swift_Mailer;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 * @Route(service="app.controller.order_controller")
 */
class OrderController
{
	/** @var CartItemFacade */
	private $cartItemFacade;

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

	/** @var Cart */
	private $cartService;

	/** @var  Swift_Mailer */
	private $swiftMailer;

	public function __construct(
		UserFacade $userFacade,
		OrderFacade $orderFacade,
		FormFactory $formFactory,
		WarehouseFacade $warehouseFacade,
		RouterInterface $router,
		Cart $cartService,
		Swift_Mailer $swiftMailer
	) {
		$this->userFacade = $userFacade;
		$this->orderFacade = $orderFacade;
		$this->formFactory = $formFactory;
		$this->warehouseFacade = $warehouseFacade;
		$this->router = $router;
		$this->cartService = $cartService;
		$this->swiftMailer = $swiftMailer;
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

			$cart = $order->getCart();
			$cartItems = $this->cartItemFacade->findByCart($cart);
			$totalPrice = $this->cartItemFacade->getTotalPrice($cartItems);

			$subject = "Nová objednávka " . $order->getId();
			$from = 'kosik@codecamp.cz';
			$to = $user->getEmail();
			$text = "Přijali jsme vaši objednávku číslo "
				. $order->getId()
				//." na produkt "
				//. $order->getItem()->getName()
				." celková cena je "
				. $totalPrice;

			$message = Swift_Message::newInstance()
				->setSubject($subject)
				->setFrom($from)
				->setTo($to)
				->setBody($text);

			$this->swiftMailer->send($message);

			return RedirectResponse::create($this->router->generate("order_thanks", ['id' => $order->getId()]));
		}

		$template = [
			"form" => $form->createView(),
			"user" => $user,
		];

		$template = $this->cartService->create($template);

		return $template;
	}

	/**
	 * @Route("/thanks/{id}", name="order_thanks")
	 * @Template("order/thanks.html.twig")
	 */
	public function actionThanks($id)
	{

		$template = [
			"user" => $this->userFacade->getUser(),
		];

		$template = $this->cartService->create($template);

		return $template;
	}

}
