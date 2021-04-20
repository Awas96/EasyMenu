<?php

namespace App\Controller;

use App\Entity\Seccion;
use App\Form\SeccionType;
use App\Repository\SeccionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeccionesController extends AbstractController
{
    /**
     * @Route("/secciones/ordenar", name="secciones_ordenar")
     */
    public function seccionesOrdenar(SeccionRepository $seccionRepository): Response
    {
        $returnURL = $_GET['returnSeccion'];
        $secciones = $seccionRepository->findAllOrderBy();
        return $this->render('secciones/Ordenar.html.twig', [
            'controller_name' => 'SeccionesController',
            'secciones' => $secciones,
            'return' => $returnURL
        ]);
    }

    /**
     * @Route("/seccion/ordenar/{sec}", name="seccion_ajax")
     */
    public function acutalizarOrden(Request $request, $sec)
    {

        $orden = $request->get('orden');
        $em = $this->getDoctrine()->getManager();
        $seccion = $em->getRepository(Seccion::class)->findById($sec);
        $seccion->setOrden($orden);
        try {
            $em->flush();

            return new jsonresponse(true);
        } catch (\PdoException $e) {
        }
    }

    /**
     * @Route("/secciones/nueva", name="seccion_nueva")
     * @Route("/secciones/modificar/{id}", name="seccion_modificar")
     */
    public function gestionarSecciones(Request $request, Seccion $seccion = null): Response
    {
        if (null == $seccion) {
            $seccion = new Seccion();
            $seccion->setOrden(0);

            $this->getDoctrine()->getManager()->persist($seccion);
        }
        $form = $this->createForm(SeccionType::class, $seccion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('indexSec', [
                'sec' => $seccion->getId()
            ]);
        }

        return $this->render('secciones/modificar.partial.html.twig', [
            'form' => $form->createView(),
            'seccion' => $seccion,

        ]);
    }

    /**
     * @Route("/secciones/eliminar/{id}", name="seccion_eliminar")
     */
    public function eliminar(Request $request, Seccion $seccion, $id): Response
    {
        if ($request->request->has('confirmar')) {
            $this->getDoctrine()->getManager()->remove($seccion);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('index', [
            ]);
        }

        return $this->render('secciones/eliminar.html.twig', [
            'seccion' => $seccion
        ]);
    }


}
