<?php

namespace App\Form;

use App\Entity\Bebida;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BebidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nombre')
            ->add('Precio')
            ->add('Descripcion')
            ->add('Stock')
            ->add('StockMin')
            ->add('StockMax')
            ->add('Foto')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bebida::class,
        ]);
    }
}
