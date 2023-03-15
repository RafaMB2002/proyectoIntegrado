<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    #[Route('/lucky/number', name: 'app_lucky_number')]
    public function luckyNumber(): Response
    {
        $number = random_int(0, 100);

        return $this->render('luckyNumber/index.html.twig', [
            'number' => $number,
        ]);
    }

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

    #[Route('/home', name: 'homepage')]
    public function homepage(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/listado', name: 'app_listado')]
    public function listado(): Response
    {
        $platos = [
            ['id' => 1, 'nombre' => 'pollo teriyaki', 'foto' => 'https://www.pequerecetas.com/wp-content/uploads/2021/04/pollo-teriyaki-receta.jpg'],
            ['id' => 2, 'nombre' => 'costilla bbq', 'foto' => 'https://t2.uc.ltmcdn.com/es/posts/3/9/5/como_hacer_costillas_bbq_en_sarten_50593_600.jpg'],
            ['id' => 3, 'nombre' => 'gambas al ajillo', 'foto' => 'https://i.blogs.es/eeeae0/gambas-al-ajillo/1366_2000.jpg']
        ];
        return $this->render('listado-platos-bebida/index.html.twig', [
            'platos' => $platos,
        ]);
    }
}
