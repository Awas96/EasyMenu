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
        $secciones = $seccionRepository->findAllOrderBy();
        return $this->render('principal/index.html.twig', [
            'controller_name' => 'PrincipalController',
            'secciones' => $secciones
        ]);
    }
    /**
     * @Route("/carta/{sec}", name="indexSec")
     */
    public function indexConSeccion(SeccionRepository $seccionRepository, ElementoRepository $elementoRepository, $sec): Response
    {
        $secciones = $seccionRepository->findAllOrderBy();
        $elemento = $elementoRepository->findSecOrderBy($sec);
        return $this->render('principal/index.html.twig', [
            'controller_name' => 'PrincipalController',
            'secciones' => $secciones,
            'nSeccion' => $sec,
            'elementos' => $elemento
        ]);
    }
}
