<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\Constraints\Dni;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;


class RegistroFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingrese un nombre.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'El nombre debe tener al menos {{ limit }} caracteres.',
                        'maxMessage' => 'El nombre no puede tener más de {{ limit }} caracteres.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-záéíóúüñÑ\s\']+$/',
                        'message' => 'El nombre ingresado no es válido.',
                        'htmlPattern' => '^[A-Za-záéíóúüñÑ\s\']+$', // Ajuste adicional para el patrón HTML
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('apellidos', TextType::class, [
                'label' => 'Apellidos',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingrese un apellido.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-záéíóúüñÑ\s\']+$/',
                        'message' => 'El apellido ingresado no es válido.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingrese un correo electrónico.',
                    ]),
                    new Email([
                        'message' => 'El correo electrónico ingresado no es válido.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('dni', TextType::class, [
                'label' => 'DNI:',
                'required' => true,
                'constraints' => [
                    new Dni(),
                    new NotBlank([
                        'message' => 'Por favor, ingrese un DNI.',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]{8}[A-Za-z]$/',
                        'message' => 'El DNI debe tener 8 dígitos seguidos de una letra.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rol',
                'required' => true,
                'choices' => [
                    'Seleccione un rol' => '',
                    'Cocinero' => 'ROLE_COCINERO',
                    'Camarero' => 'ROLE_CAMARERO',
                    'Jefe' => 'ROLE_JEFE'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Debe seleccionar un rol',
                    ]),
                    new Choice([
                        'choices' => ['ROLE_COCINERO', 'ROLE_CAMARERO', 'ROLE_JEFE'],
                        'message' => 'El rol seleccionado no es válido.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña:',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingrese una contraseña.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('confirm_password', PasswordType::class, [
                'label' => 'Confirmar contraseña',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingrese una contraseña.',
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            /* 'data_class' => User::class, */]);
    }
}
