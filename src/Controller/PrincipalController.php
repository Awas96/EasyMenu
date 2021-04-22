<?php

namespace App\Controller;

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
}
