<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistroFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistroController extends AbstractController
{
    #[Route('/registro', name: 'registro')]
    public function registro(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(RegistroFormType::class);
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('registro/registro.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    #[Route('/registro/procesar', name: 'registro_procesar', methods: 'POST')]
    public function procesarRegistro(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(RegistroFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtener los datos del formulario
            $datos = $form->getData();
            $roles = json_decode($datos['roles'], true);
            $datos['roles'] = [$roles];

            // Crear una instancia de la entidad User y asignar los datos
            $user = new User();
            $user->setDni($datos['dni'])
                ->setRoles($datos['roles'])
                ->setPassword($datos['password'])
                ->setEmail($datos['email'])
                ->setNombre($datos['nombre'])
                ->setApellidos($datos['apellidos']);

            $entityManager->persist($user);
            $entityManager->flush();

            // Redirigir a una página de éxito o mostrar un mensaje de éxito
            return $this->redirectToRoute('homepage');
        }

        return $this->render('registro/registro.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
