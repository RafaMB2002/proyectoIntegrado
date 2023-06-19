<?php

namespace App\Controller\Admin;

use App\Entity\Mesa;
use App\Form\MesaType;
use App\Repository\MesaRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mesa/crud')]
class MesaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mesa::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_EDIT == $pageName || Crud::PAGE_NEW == $pageName) {
            return [
                NumberField::new('comensales')
            ];
        }
        return [
            IdField::new('id'),
            NumberField::new('comensales')
        ];
    }
}
