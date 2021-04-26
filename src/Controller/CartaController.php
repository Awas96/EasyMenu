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
            'icono' => $seccion->getIcono(),
            'orden' => "0",
            'ordenSec' => $seccion->getOrden()
        ]);
        foreach ($elemento as $item) {
            if ($item->getVisible() == "1") {
                $item = array(
                    'tipo' => 'elemento',
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre(),
                    'precio' => $item->getPrecio(),
                    'descripcion' => $item->getdescripcion(),
                    'orden' => $item->getOrden(),
                );
                array_push($arr, $item);
            }
        }
        dump($arr);
        usort($arr, function ($a, $b) {
            return strcmp($a["orden"], $b["orden"]);
        });

        try {
            return new JsonResponse($arr);
        } catch (\PdoException $e) {
        }
    }


}
