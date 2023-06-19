<?php

namespace App\Controller\Admin;

use App\Controller\JsonTextareaType;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use RolesTextareaType;
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
        if (Crud::PAGE_EDIT == $pageName || Crud::PAGE_NEW == $pageName) {
            return [
                TextField::new('dni'),
                TextField::new('nombre'),
                TextField::new('apellidos'),
                TextField::new('email'),
                TextField::new('password', 'password'),
                ChoiceField::new('roles')->setChoices([
                    'Jefe' => 'ROLE_JEFE',
                    'Camarero' => 'ROLE_CAMARERO',
                    'Cocinero' => 'ROLE_COCINERO'
                ])->allowMultipleChoices()->autocomplete()
            ];
        }
        return [
            TextField::new('dni'),
            TextField::new('nombre'),
            TextField::new('apellidos'),
            TextField::new('email'),
            CollectionField::new('roles')
                ->setEntryType(TextField::class)
        ];
    }
}
