<?php

namespace App\Controller\Admin;

use App\Entity\Plato;
use App\Form\PlatoType;
use App\Repository\PlatoRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/plato/crud')]
class PlatoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plato::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if(Crud::PAGE_EDIT == $pageName){
            return [
                IdField::new('id'),
                TextField::new('nombre'),
                TextField::new('descripcion'),
                NumberField::new('precio')
            ];
        }
        return [
            IdField::new('id'),
            TextField::new('nombre'),
            TextField::new('descripcion'),
            NumberField::new('precio')
        ];
    }
}
