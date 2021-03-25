<?php

namespace App\Controller;

use App\Entity\Alergeno;
use App\Repository\AlergenoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlergenoController extends AbstractController
{
    /**
     * @Route("/alergeno/listar", name="lista_alergenos")
     */
    public function listaAlergenos(AlergenoRepository $alergenoRepository, Alergeno $alergeno): Response
    {
        $alergenos = $alergenoRepository->findAll();
        return $this->render('alergeno/listar.html.twig', [
            'controller_name' => 'AlergenoController',
            'alergenos' => $alergeno
        ]);
    }
}
