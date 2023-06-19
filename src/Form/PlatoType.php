<?php

namespace App\Form;

use App\Entity\Plato;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlatoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nombre')
            ->add('Descripcion')
            ->add('ValoresNutricionales')
            ->add('Alergenos')
            ->add('Precio')
            ->add('Tipo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plato::class,
        ]);
    }
}
