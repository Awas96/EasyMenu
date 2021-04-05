<?php

namespace App\Controller;

use App\Repository\ElementoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElementoController extends AbstractController
{
    /**
     * @Route("/elemento/listar/{sec}", name="lista_elementos")
     */
    public function listaElementos(ElementoRepository $elementoRepository, $sec): Response
    {
        $elemento = $elementoRepository->listarElementos($sec);
        return $this->render('elemento/listar.html.twig', [
            'controller_name' => 'ElementoController',
            'elementos' => $elemento
        ]);
    }
}
