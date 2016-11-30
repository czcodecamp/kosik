<?php
namespace AppBundle\FormType;

use AppBundle\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 */
class OrderFormType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('deliveryType', ChoiceType::class, [
				'label' => "Způsob dopravy",
				'choices' => [
					"Osobní odběr" => Order::DELIVERY_TYPE_SHOP,
					"Česká pošta" => Order::DELIVERY_TYPE_POST,
				],
				"attr" => [
					"class" => "form-control",
				],
			])
			->add('warehouse', ChoiceType::class, [
				'label' => "Pobočka",
				'choices' => [
					'Budějovická' => 2,
					'Anděl' => 3,
				],
				"attr" => [
					"class" => "form-control",
				],
			])
			->add('paymentType', ChoiceType::class, [
				'label' => "Způsob platby",
				'choices' => [
					"Hotově" => Order::PAYMENT_TYPE_CASH,
					"Kartou" => Order::PAYMENT_TYPE_CARD,
				],
				"attr" => [
					"class" => "form-control",
				],
			])
			->add('delivery', AddressFormType::class, [
				'label' => 'Dodací adresa:',
				'required' => false
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\FormType\VO\OrderVO',
		));
	}
}