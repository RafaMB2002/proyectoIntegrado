<?php

namespace App\Controller;

use App\Entity\Presencia;
use App\Repository\PresenciaRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PresenciaController extends AbstractController
{
    /**
     * Me lleva a la plantilla de presencia
     */
    #[Route('/presencia', name: 'app_presencia')]
    public function index(): Response
    {
        return $this->render('presencia/index.html.twig', [
            'controller_name' => 'PresenciaController',
        ]);
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository repositorio de la entidad user
     * @param EntityManagerInterface $entityManagerInterface  
     */
    #[Route('/guardar-ficha-entrada', name: 'guardar_ficha_entrada', methods: 'POST')]
    public function guardarFichaEntrada(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        // Obtener el usuario correspondiente al DNI
        $usuario = $userRepository->findOneBy(['dni' => $data['dni']]);

        // Guardar la ficha de entrada en la base de datos
        $presencia = new Presencia();
        $presencia->setFechaHoraEntrada(new DateTime($data['fechaHora']));
        $presencia->setUser($usuario);

        $entityManager->persist($presencia);
        $entityManager->flush();

        return new Response('Ficha de entrada guardada correctamente');
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository repositorio de la entidad user
     * @param EntityManagerInterface $entityManagerInterface  
     * @param PresenciaRepository $presenciaRepository Repositorio de la entidad presencia
     */
    #[Route('/guardar-ficha-salida', name: 'guardar_ficha_salida', methods: 'POST')]
    public function guardarFichaSalida(Request $request, UserRepository $userRepository, PresenciaRepository $presenciaRepository, EntityManagerInterface $entityManager): Response
    {

        $data = json_decode($request->getContent(), true);

        // Obtener el usuario correspondiente al DNI
        $usuario = $userRepository->findOneBy(['dni' => $data['dni']]);

        // Obtener la última ficha de entrada del usuario
        $presencia = $presenciaRepository->findOneBy(
            ['user' => $usuario->getId()],
            ['FechaHoraEntrada' => 'DESC']
        );

        if ($presencia) {
            // Guardar la ficha de salida en la base de datos
            $presencia->setFechaHoraSalida(new DateTime($data['fechaHora']));
            $entityManager->flush();

            return new Response('Ficha de salida guardada correctamente');
        }

        return new Response('No se encontró una ficha de entrada para el usuario');
    }
}
