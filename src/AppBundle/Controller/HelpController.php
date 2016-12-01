<?php
namespace AppBundle\Controller;

use AppBundle\Service\Cart;
use AppBundle\Entity\SupportTicket;
use AppBundle\Facade\HelpFacade;
use AppBundle\Facade\UserFacade;
use AppBundle\FormType\SupportTicketFormType;
use AppBundle\Repository\FaqRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 * @Route(service="app.controller.help_controller")
 */
class HelpController
{
	private $faqRepository;
	private $formFactory;
	private $helpFacade;
	private $userFacade;

	/** @var Cart */
	private $cartService;

	public function __construct(
		FaqRepository $faqRepository,
		FormFactory $formFactory,
		HelpFacade $helpFacade,
		UserFacade $userFacade,
		Cart $cartService
	) {
		$this->faqRepository = $faqRepository;
		$this->formFactory = $formFactory;
		$this->helpFacade = $helpFacade;
		$this->userFacade = $userFacade;
		$this->cartService = $cartService;
	}

	/**
	 * @Route("/faq", name="faq")
	 * @Template("help/faq.html.twig")
	 *
	 * @return array
	 */
	public function faqAction()
	{
		$template = [
			"faqs" => $this->faqRepository->findAll(),
		];

		$template = $this->cartService->create($template);

		return $template;
	}

	/**
	 * @Route("/kontakt", name="contact")
	 * @Template("help/contact.html.twig")
	 *
	 * @param Request $request
	 * @return array
	 */
	public function contactAction(Request $request)
	{
		$saved = false;

		$ticket = $this->userFacade->getUser()
			? SupportTicket::createForUser($this->userFacade->getUser())
			: new SupportTicket();
		$form = $this->formFactory->create(SupportTicketFormType::class, $ticket);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->helpFacade->saveSupportTicket($ticket);
			$saved = true;
		}
		$template = [
			"saved" => $saved,
			"form" => $form->createView(),
		];

		$template = $this->cartService->create($template);

		return $template;
	}

}