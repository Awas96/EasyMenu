<?php

namespace App\Controller;

use App\Entity\Elemento;
use App\Form\ElementoType;
use App\Repository\ElementoRepository;
use App\Repository\SeccionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'elementos' => $elemento,
        ]);
    }

    /**
     * @Route("/elemento/{sec}/nuevo/", name="elemento_nuevo")
     * @Route("/elemento/modificar/{id}", name="elemento_modificar")
     */
    public function gestionarElementos(Request $request, Elemento $elemento = null, SeccionRepository $seccionRepository, $sec = null): Response
    {

        if (null == $elemento) {
            $elemento = new Elemento();
            $elemento->setVisible(true);
            $elemento->setOrden(0);
            $elemento->setSeccion($seccionRepository->findById($sec));
            $this->getDoctrine()->getManager()->persist($elemento);
        } else {
            $sec = $seccionRepository->findById($elemento->getSeccion())->getId();
        }

        $form = $this->createForm(ElementoType::class, $elemento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            /*return $this->redirectToRoute('indexSec', [
                'sec' => $sec
            ]);*/
        }

        return $this->render('elemento/modificar.partial.html.twig', [
            'form' => $form->createView(),
            'elemento' => $elemento,

        ]);
    }

    /**
     * @Route("/elemento/{sec}/eliminar/{id}", name="elemento_eliminar")
     */
    public function eliminar(Request $request, Elemento $elemento, $id, $sec): Response
    {
        if ($request->request->has('confirmar')) {
            $this->getDoctrine()->getManager()->remove($elemento);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('indexSec', [
                'sec' => $sec
            ]);
        }

        return $this->render('elemento/eliminar.html.twig', [
            'elemento' => $elemento
        ]);
    }

    /**
     * @Route("/elemento/ocultar/{id}", name="elemento_ocultar")
     */
    public function OcultarElemento(Elemento $elemento, ElementoRepository $elementoRepository, $id): Response
    {
        $sec = $_GET["sec"];
        $elemento = $elementoRepository->GetElementByID($id);
        $estado = $elemento->getVisible();
        if ($estado) {
            $elemento->setVisible(false);
        } else {
            $elemento->setVisible(true);
        }
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('indexSec', [
            'sec' => $sec
        ]);
    }

}
