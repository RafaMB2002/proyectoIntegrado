<?php

namespace App\Controller\Admin;

use App\Entity\Bebida;
use App\Form\BebidaType;
use App\Repository\BebidaRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bebida/crud')]
class BebidaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bebida::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if(Crud::PAGE_EDIT == $pageName || Crud::PAGE_NEW == $pageName){
            return [
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
