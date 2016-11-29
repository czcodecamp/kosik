<?php
namespace AppBundle\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 */
class AddressFormType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add("firstName", TextType::class, [
			"label" => "Jméno",
			"attr" => [
				"class" => "form-control",
			]
		])->add("lastName", TextType::class, [
			"label" => "Příjmení",
			"attr" => [
				"class" => "form-control",
			]
		])->add("street", TextType::class, [
			"label" => "Ulice a č.p.",
			"attr" => [
				"class" => "form-control",
			]
		])->add("city", TextType::class, [
			"label" => "Město",
			"attr" => [
				"class" => "form-control",
			]
		])->add("postCode", TextType::class, [
			"label" => "PSČ",
			"attr" => [
				"class" => "form-control",
			]
		])->add("phone", TextType::class, [
			"label" => "Telefonní číslo",
			"attr" => [
				"class" => "form-control",
			]
		]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\FormType\VO\AddressVO',
		));
	}

}