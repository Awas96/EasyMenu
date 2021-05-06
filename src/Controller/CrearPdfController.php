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

        $seleccion = null;
        $opciones = null;
        if ($opcion == 1) {

            $opciones = new Options();
            $opciones->setIsHtml5ParserEnabled(true);
            $opciones->setisRemoteEnabled(true);
            $opciones->setisJavascriptEnabled(true);
            $opciones->setIsPhpEnabled(true);
            $seleccion = new Dompdf($opciones);
        } else {
            /* $seleccion = $image;
             dump($image);
             $seleccion->setOption('format', 'png');
             $seleccion->setOption('crop-w', '1122');
             $seleccion->setOption('quality', '100');*/
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
        }


        if ($opcion == 1) {
            $htmls = trim($html, "\t\n\r\0\x0B");
            $seleccion->loadHtml($htmls);
            $seleccion->setPaper('A4', 'landscape');
            $seleccion->render();
            $seleccion->stream("Carta.pdf", [
                "Attachment" => true
            ]);

        } else {
            return new JpegResponse(
                $seleccion->getOutputFromHtml($html),
                'carta.png'
            );
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
