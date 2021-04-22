<?php

namespace App\Controller;

use App\Repository\ElementoRepository;
use App\Repository\SeccionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartaController extends AbstractController
{

    /**
     * @Route("/carta/{sec}", name="indexSec")
     */
    public function indexConSeccion(SeccionRepository $seccionRepository, ElementoRepository $elementoRepository, $sec): Response
    {
        $secciones = $seccionRepository->findAllOrderBy();
        $elemento = $elementoRepository->findSecOrderBy($sec);
        return $this->render('carta/seccion.html.twig', [
            'controller_name' => 'PrincipalController',
            'secciones' => $secciones,
            'nSeccion' => $sec,
            'elementos' => $elemento
        ]);
    }


    /**
     * @Route("/carta/datos/{sec}", name="carta_datos")
     */
    public function getSeccion(SeccionRepository $seccionRepository, ElementoRepository $elementoRepository, $sec): Response
    {
        $elemento = $elementoRepository->listarElementos($sec);
        $seccion = $seccionRepository->findById($sec);
        $arr = [];
        array_push($arr, [
            'tipo' => 'seccion',
            'id' => $seccion->getId(),
            'titulo' => $seccion->getNombre(),
            'icono' => $seccion->getIcono()
        ]);
        foreach ($elemento as $item) {
            $elemento = array(
                'tipo' => 'elemento',
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'precio' => $item->getPrecio(),
                'descripcion' => $item->getdescripcion(),
            );
            array_push($arr, $elemento);
        }

        try {
            return new JsonResponse($arr);
        } catch (\PdoException $e) {
        }
    }


}
