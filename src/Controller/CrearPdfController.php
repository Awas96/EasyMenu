<?php

namespace App\Controller;

use App\Repository\ElementoRepository;
use App\Repository\SeccionRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Bundle\SnappyBundle\Snappy\Response\JpegResponse;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrearPdfController extends AbstractController
{
    /**
     * @Route("/crearpdf/{opcion}/generar/{slug}", name="genera_pdf")
     */
    public function generate_pdf(ElementoRepository $elementoRepository, $slug, $opcion = null)
    {
        $html = null;
        $seleccion = null;
        $opciones = null;
        if ($opcion == 1) {

            $opciones = new Options();
            $opciones->setIsHtml5ParserEnabled(true);
            $opciones->setisRemoteEnabled(true);
            $seleccion = new Dompdf($opciones);
        } else {
            $opciones = new Options();
            $opciones->setIsHtml5ParserEnabled(true);
            $opciones->setisRemoteEnabled(true);
            $seleccion = new Dompdf($opciones);
        }
        $arr = json_decode($slug);
        usort($arr, function ($a, $b) {
            return strcmp($a[1], $b[1]);
        });
        $elementos = [];
        foreach ($arr as $el) {
            array_push($elementos, $elementoRepository->listarElementos($el[0]));
        }
        switch (2) {
            case 1:
                return $this->render('crearCarta/exportador.html.twig', [
                    'datos' => $elementos
                ]);
            case 2:
                $html = $this->renderView('crearCarta/exportador.html.twig', [
                    'datos' => $elementos
                ]);
                $html = preg_replace('/>\s+</', "><", $html);
        }


        if ($opcion == 1) {

            $seleccion->loadHtml($html);
            $seleccion->setPaper('A4', 'landscape');
            $seleccion->render();
            $seleccion->stream("Carta.pdf", [
                "Attachment" => true
            ]);

        } else {

            $seleccion->loadHtml($html);
            $seleccion->setPaper('A4', 'landscape');
            $seleccion->render();
            $seleccion->stream("Carta.jpg");
        }
        try {
            return new JsonResponse(true);
        } catch (\PdoException $e) {
        }

    }

    /**
     * @Route("/crearpdf/formulario/{opcion}", name="generar_carta")
     */
    public function generarCarta(SeccionRepository $seccionRepository, $opcion): Response
    {
        $secciones = $seccionRepository->findAllOrderBy();


        return $this->render('crearCarta/generar.html.twig', [
            'secciones' => $secciones,
            'opcion' => $opcion
        ]);
    }

}
