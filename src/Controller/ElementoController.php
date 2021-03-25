<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElementoController extends AbstractController
{
    /**
     * @Route("/elemento/listar", name="lista_elementos")
     */
    public function listaElementos(ElementoRepository $elementoRepository): Response
    {   $elemento = $elementoRepository->findAll();
        return $this->render('elemento/index.html.twig', [
            'controller_name' => 'ElementoController',
            'elementos' => $elemento
        ]);
    }
}
