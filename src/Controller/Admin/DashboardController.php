<?php

namespace App\Controller\Admin;

use App\Entity\Bebida;
use App\Entity\Mesa;
use App\Entity\Plato;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
        //return parent::index();

        //$adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        //return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ProyectoJuegosMesa')
            ->setFaviconPath('public\img\favicon\mesa-circular.svg')
            ->disableDarkMode()
            ->setLocales(['es', 'en']);
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Inicio','fa fa-home','/');
        yield MenuItem::linkToCrud('Usuario', 'fa-sharp fa-solid fa-users', User::class);
        yield MenuItem::linkToCrud('Bebida', 'fa-sharp fa-solid', Bebida::class);
        yield MenuItem::linkToCrud('Plato', 'fa-sharp fa-solid', Plato::class);
        yield MenuItem::linkToCrud('Mesa', 'fa-sharp fa-solid', Mesa::class);
    }
}
