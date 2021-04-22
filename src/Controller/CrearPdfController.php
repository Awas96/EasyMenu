<?php

namespace App\Controller;

use App\Repository\ElementoRepository;
use App\Repository\SeccionRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrearPdfController extends AbstractController
{
    /**
     * @Route("/crearpdf/generar/", name="genera_pdf")
     */
    public function generate_pdf(SeccionRepository $seccionRepository, ElementoRepository $elementoRepository, $sec)
    {

        $options = new Options();
        $options->set('defaultFont', 'Roboto');
        $secciones = $seccionRepository->findAllOrderBy();
        $elemento = $elementoRepository->findSecOrderBy($sec);

        $dompdf = new Dompdf($options);

        $data = array(
            'headline' => 'xDDD'
        );
        $html = $this->renderView('principal/index.html.twig', [
            'headline' => "Test pdf generator",
            "Attachment" => true,
            'secciones' => $secciones,
            'nSeccion' => $sec,
            'elementos' => $elemento
        ]);


        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("testpdf.pdf", [
            "Attachment" => true,
            'secciones' => $secciones,
            'nSeccion' => $sec,
            'elementos' => $elemento
        ]);

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
