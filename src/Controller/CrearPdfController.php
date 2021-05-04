<?php

namespace App\Controller;

use App\Repository\ElementoRepository;
use App\Repository\SeccionRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\JpegResponse;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Image;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrearPdfController extends AbstractController
{
    /**
     * @Route("/crearpdf/{opcion}/generar/{slug}", name="genera_pdf")
     */
    public function generate_pdf(Image $image, Pdf $pdf, ElementoRepository $elementoRepository, $slug, $opcion = null)
    {

        $seleccion = null;
        if ($opcion == 1) {
            $seleccion = $pdf;
            $seleccion->setOption('orientation', 'Landscape');
            $seleccion->setOption('page-size', 'A4');
            $seleccion->setOption('dpi', '500');
            $seleccion->setOption('margin-bottom', '0');
            $seleccion->setOption('margin-top', '0');
            $seleccion->setOption('margin-right', '0');
            $seleccion->setOption('margin-left', '0');
        } else {
            $seleccion = $image;
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

        dump($seleccion);

        if ($opcion == 1) {
            return new PdfResponse(
                $seleccion->getOutputFromHtml($html),
                'carta.pdf'
            );
        } else {
            return new JpegResponse(
                $seleccion->getOutputFromHtml($html),
                'carta.jpg'
            );
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
