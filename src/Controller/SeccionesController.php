<?php

namespace App\Controller;

use App\Repository\SeccionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeccionesController extends AbstractController
{
    /**
     * @Route("/secciones/listar", name="secciones")
     */
    public function seccionesListar(SeccionRepository $seccionRepository): Response
    {
        $secciones = $seccionRepository->findAll();
        return $this->render('secciones/listar.html.twig', [
            'controller_name' => 'SeccionesController',
            'seccion' => $secciones
        ]);
    }
}
