<?php

namespace App\Controller;

use App\Entity\Elemento;
use App\Form\ElementoType;
use App\Repository\ElementoRepository;
use App\Repository\SeccionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElementoController extends AbstractController
{
    /**
     * @Route("/elemento/ordenar/{sec}", name="elemento_ordenar")
     */
    public function ordenaElementos(ElementoRepository $elementoRepository, $sec): Response
    {
        $elementos = $elementoRepository->findSecOrderBy($sec);
        return $this->render('elemento/ordenar.html.twig', [
            'controller_name' => 'SeccionesController',
            'elementos' => $elementos,
            'sec' => $sec
        ]);
    }

    /**
     * @Route("/elemento/AJAX/{id}", name="elemento_ajax")
     */
    public function acutalizarOrden(Request $request, $id)
    {

        $orden = $request->get('orden');
        $em = $this->getDoctrine()->getManager();
        $elemento = $em->getRepository(Elemento::class)->GetElementByID($id);
        $elemento->setOrden($orden);

        try {
            $em->flush();
            $this->addFlash('notice',
                'Tus cambios se han guardado!');
            return new jsonresponse(true);
        } catch (\PdoException $e) {
        }
    }

    /**
     * @Route("/elemento/{sec}/nuevo/", name="elemento_nuevo")
     * @Route("/elemento/modificar/{id}", name="elemento_modificar")
     */
    public function gestionarElementos(Request $request, Elemento $elemento = null, SeccionRepository $seccionRepository, $sec = null): Response
    {

        if (null == $elemento) {
            $elemento = new Elemento();
            $elemento->setPrecio(0.00);
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

            if(!$form->get('saveAndAdd')->isClicked()) {
                return $this->redirectToRoute('indexSec', [
                    'sec' => $sec
                ]);
            }
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

        $elemento = $elementoRepository->GetElementByID($id);
        $estado = $elemento->getVisible();
        if ($estado) {
            $elemento->setVisible(false);
        } else {
            $elemento->setVisible(true);
        }
        $em = $this->getDoctrine()->getManager();
        try {
            $em->flush();
            return new jsonresponse(true);
        } catch (\PdoException $e) {
        }
    }

}
