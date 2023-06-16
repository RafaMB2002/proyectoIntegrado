<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/user/crud')]
class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if(Crud::PAGE_EDIT == $pageName){
            return [
                IdField::new('id'),
                TextField::new('nombre'),
                TextField::new('apellidos'),
                TextField::new('email'),
                ImageField::new('avatar')->setUploadDir('public\img\avatar')
            ];
        }
        return [
            IdField::new('id'),
            TextField::new('nombre'),
            TextField::new('apellidos'),
            TextField::new('email'),
            ImageField::new('avatar')->setBasePath('img/avatar')
        ];
    }
}
