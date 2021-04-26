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
        $html = $this->renderView('crearCarta/exportador.html.twig', [
            'headline' => "Test pdf generator",
            "Attachment" => true,
            'datos' => $elementos
        ]);
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
