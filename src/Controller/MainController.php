<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * Muestra un número de la suerte aleatorio.
     *
     * @Route("/lucky/number", name="app_lucky_number")
     * @return Response Respuesta HTTP que muestra el número de la suerte.
     */
    #[Route('/lucky/number', name: 'app_lucky_number')]
    public function luckyNumber(): Response
    {
        $number = random_int(0, 100);

        return $this->render('luckyNumber/index.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * Redirige a la página de inicio.
     *
     * @Route("/index", name="app_main")
     * @return RedirectResponse Redirección HTTP a la página de inicio.
     */
    #[Route('/index', name: 'app_main')]
    public function index(): RedirectResponse
    {
        // redirects to the "homepage" route
        return $this->redirectToRoute('homepage');

        // redirectToRoute is a shortcut for:
        // return new RedirectResponse($this->generateUrl('homepage'));

        // does a permanent HTTP 301 redirect
        //return $this->redirectToRoute('homepage', [], 301);
        // if you prefer, you can use PHP constants instead of hardcoded numbers
        //return $this->redirectToRoute('homepage', [], Response::HTTP_MOVED_PERMANENTLY);

        // redirect to a route with parameters
        //return $this->redirectToRoute('app_lucky_number', ['max' => 10]);

        // redirects to a route and maintains the original query string parameters
        //return $this->redirectToRoute('blog_show', $request->query->all());

        // redirects to the current route (e.g. for Post/Redirect/Get pattern):
        //return $this->redirectToRoute($request->attributes->get('_route'));

        // redirects externally
        // return $this->redirect('http://symfony.com/doc');
    }

    /**
     * Muestra la página de inicio.
     *
     * @Route("/home", name="homepage")
     * @return Response Respuesta HTTP que muestra la página de inicio.
     */
    #[Route('/home', name: 'homepage')]
    public function homepage(): Response
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * Muestra la página de inicio.
     *
     * @Route("/", name="homepage2")
     * @return Response Respuesta HTTP que muestra la página de inicio.
     */
    #[Route('/', name: 'homepage2')]
    public function homepage2(): Response
    {
        return $this->render('main/index.html.twig');
    }
}
