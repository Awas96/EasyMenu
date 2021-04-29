<?php

namespace App\Controller;

use App\Repository\ElementoRepository;
use App\Repository\SeccionRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrearPdfController extends AbstractController
{
    /**
     * @Route("/crearpdf/generar/{slug}", name="genera_pdf")
     */
    public function generate_pdf(Pdf $pdf, ElementoRepository $elementoRepository, $slug)
    {
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
        $pdf->setOption('orientation', 'Landscape');
        $pdf->setOption('page-size', 'A4');
        $pdf->setOption('dpi', '500');
        $pdf->setOption('margin-bottom', '0');
        $pdf->setOption('margin-top', '0');
        $pdf->setOption('margin-right', '0');
        $pdf->setOption('margin-left', '0');
        dump($pdf);
        return new PdfResponse(
            $pdf->getOutputFromHtml($html),
            'carta.pdf'
        );

    }

    /**
     * @Route("/crearpdf/formulario", name="generarCarta")
     */
    public function generarCarta(SeccionRepository $seccionRepository): Response
    {
        $secciones = $seccionRepository->findAllOrderBy();


        return $this->render('crearCarta/generar.html.twig', [
            'controller_name' => 'PrincipalController',
            'secciones' => $secciones
        ]);
    }

}
