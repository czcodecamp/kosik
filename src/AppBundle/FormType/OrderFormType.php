<?php
namespace AppBundle\FormType;

use AppBundle\Entity\Order;
use AppBundle\FormType\AddressFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 */
class OrderFormType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add(
			$builder->create('delivery', AddressFormType::class, [
				'label' => 'Dodací adresa:',
			])
		)->add('isInvoice', ChoiceType::class, array(
			'choices'  => array(
				'Yes' => true,
				'No' => false,
			),
		))->add(
			$builder->create('invoice', AddressFormType::class, [
				'label' => 'Fakturační adresa:',
			])
		);
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults([

		]);
	}

}