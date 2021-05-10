<?php

namespace App\Controller;


use App\Entity\Seccion;
use App\Entity\User;
use App\Form\UserNameType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/panel", name="app_panel")
     */
    public function panelAdmin()
    {
        return $this->render('security/panel_administrador.html.twig', [
        ]);
    }

    /**
     * @Route("/panel/contrasenya/{user}", name="app_password_change")
     */
    public function modifica_Usuario_password(Request $request, UserPasswordEncoderInterface $passwordEncoder, $user = null, UserRepository $userRepository)
    {

        $user = $userRepository->findOneById($user);
        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_panel');
        }

        return $this->render('user/modificar.html.twig', [
            'form' => $form->createView(),
            'usuario' => $user,
            'tipo' => 'pw'
        ]);

    }

    /**
     * @Route("/panel/username/{user}", name="app_username_change")
     */
    public function modifica_Usuario_username(Request $request, $user = null, UserRepository $userRepository)
    {

        $user = $userRepository->findOneById($user);
        $form = $this->createForm(UserNameType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_panel');
        }

        return $this->render('user/modificar.html.twig', [
            'form' => $form->createView(),
            'usuario' => $user,
            'tipo' => 'un'
        ]);

    }

    /**
     * @Route("/panel/pormocionar/{user}", name="app_user_promocionar")
     */
    public function modifica_Usuario_rol(Request $request, $user = null, UserRepository $userRepository)
    {

        $user = $userRepository->findOneById($user);
        $user->setRoles(1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_panel');


    }


    /**
     * @Route("/panel/usuarios/{estado}", name="app_panel_listar")
     */
    public function gestiona_usuarios(UserRepository $userRepository, $estado)
    {
        $users = $userRepository->findAll();
        return $this->render('user/listar.html.twig', [
            'usuarios' => $users,
            'estado' => $estado
        ]);

    }

    /**
     * @Route("/panel/elimina_usuario/{id}", name="app_user_delete")
     */
    public function eliminar(Request $request, User $usuario, $id): Response
    {
        if ($request->request->has('confirmar')) {
            $this->getDoctrine()->getManager()->remove($usuario);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('app_panel', [
            ]);
        }

        return $this->render('user/eliminar.html.twig', [
            'usuario' => $usuario
        ]);
    }


}
