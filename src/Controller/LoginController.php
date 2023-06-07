<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /* #[Route('/login_check', name: 'app_login_check')]
    public function loginCheck(Request $request, Security $security, AuthenticationUtils $authenticationUtils)
    {
        // Obtener los datos del formulario
        $dni = $request->request->get('login_form')['dni'];
        $contraseña = $request->request->get('login_form')['contraseña'];

        // Validar los datos del formulario si es necesario

        // Intentar autenticar al usuario
        $user = $security->getUser();
        if ($user) {
            // El usuario ya está autenticado
            // Redirigir a la página de inicio
            return $this->redirectToRoute('app_homepage');
        }

        // Autenticar manualmente al usuario
        $token = new UsernamePasswordToken($dni, $contraseña, 'main', ['ROLE_USER']);
        try {
            $authenticatedToken = $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($authenticatedToken));

            // Redirigir a la página de inicio después de iniciar sesión con éxito
            return $this->redirectToRoute('app_homepage');
        } catch (AuthenticationException $exception) {
            // La autenticación falló
            // Mostrar un mensaje de error o realizar alguna otra acción
        }
    } */

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        // Esta acción no requiere implementación, Symfony se encarga del cierre de sesión automáticamente
    }
}
