<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\Login;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
   
     /**
     * @Route("/login", name="login_seguro" )
     */
    public function loginUsuario(Request $request, AuthenticationUtils $authUtils)
    {
        // Capturamos el error de autenticación
        $error = $authUtils->getLastAuthenticationError();
        // Último nombre de usuario autenticado
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/nuevousuario", name="usuariobd")
     */
    public function nuevoUsuarioBd()
    {
        $em=$this->getDoctrine()->getManager();
        $usuario=new Usuario();
        $usuario->setEmail("jorge@gm.com");
        $usuario->setUsername("jorge");
        $password = $this->get('security.password_encoder')
            ->encodePassword($usuario, "Temporal");
        $usuario->setPassword($password);
        $em->persist($usuario);
        $em->flush();
        return new Response("Usuario guardado!");
    }

}
