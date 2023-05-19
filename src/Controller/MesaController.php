<?php

namespace App\Controller;

use App\Entity\Mesa;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesaController extends AbstractController
{
    #[Route('/mesa', name: 'create_mesa')]
    public function createMesa(EntityManagerInterface $entityManager): Response
    {
        $mesa = new Mesa();

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($mesa);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Guardada nueva mesa con id ' . $mesa->getId());
    }
}