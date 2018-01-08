<?php

namespace  Athena\IhmBundle\Form;

use Athena\IhmBundle\Entity\Conf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConfType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			// ...
			->add('conf', FileType::class, array('label' => 'Conf Athena'))
			->add('save', SubmitType::class, array('label' => 'Envoyer'))
			// ...
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Conf::class,
		));
	}
}