<?php

namespace App\Controller;

use App\Repository\ElementoRepository;
use App\Repository\SeccionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SeccionRepository $seccionRepository): Response
    {
        $secciones = $seccionRepository->findAll();
        return $this->render('principal/index.html.twig', [
            'controller_name' => 'PrincipalController',
            'secciones' => $secciones
        ]);
    }
    /**
     * @Route("/{sec}", name="indexSec")
     */
    public function indexConSeccion(SeccionRepository $seccionRepository, ElementoRepository $elementoRepository, $sec): Response
    {
        $secciones = $seccionRepository->findAll();
        $elemento = $elementoRepository->listarElementos($sec);
        return $this->render('principal/index.html.twig', [
            'controller_name' => 'PrincipalController',
            'secciones' => $secciones,
            'seccion' => $sec,
            'elementos' => $elemento
        ]);
    }
}
