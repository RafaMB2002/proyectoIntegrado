<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
            ])
            ->add('apellidos', TextType::class, [
                'label' => 'Apellidos',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
            ])
            ->add('dni', TextType::class, [
                'label' => 'DNI',
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rol',
                'choices' => [
                    'Trabajador' => 'ROLE_TRABAJADOR',
                    'Camarero' => 'ROLE_CAMARERO',
                    'Jefe' => 'ROLE_JEFE'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            /* 'data_class' => User::class, */
        ]);
    }
}
