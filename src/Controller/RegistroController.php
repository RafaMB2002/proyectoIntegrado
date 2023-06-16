<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistroFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class RegistroController extends AbstractController
{
    /**
     * @param AuthenticationUtils $authenticationsUtils Libreria para para logear a un usuario
     */
    #[Route('/registro', name: 'registro')]
    public function registro(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(RegistroFormType::class);
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('registro/registro.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @param Request $request para la peticion HTTP
     * @param EntityManagerInterface $entityManagerInterface
     * @param UserPasswordHasherInterface $userPasswordHasherInterface
     * @param AuthenticationUtils $authenticationUtils
     * @param RegistroFormType $form
     */
    #[Route('/registro/procesar', name: 'registro_procesar', methods: 'POST')]
    public function procesarRegistro(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, AuthenticationUtils $authenticationUtils, RegistroFormType $form)
    {
        $form = $this->createForm(RegistroFormType::class);
        $form->handleRequest($request);
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtener los datos del formulario
            $datos = $form->getData();
            $user = new User();
            $roles = [];
            array_push($roles, $datos['roles']);
            $plaintextPassword = $datos['password'];
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );

            if ($datos['password'] !== $datos['confirm_password']) {
                $form['confirm_password']->addError(new FormError('Las contraseñas no coinciden.'));
            } else {
                // Crear una instancia de la entidad User y asignar los datos

                $user->setDni($datos['dni'])
                    ->setRoles($roles)
                    ->setPassword($hashedPassword)
                    ->setEmail($datos['email'])
                    ->setNombre($datos['nombre'])
                    ->setApellidos($datos['apellidos']);

                $entityManager->persist($user);
                $entityManager->flush();

                // Redirigir a una página de éxito o mostrar un mensaje de éxito
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('registro/registro.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }
}
