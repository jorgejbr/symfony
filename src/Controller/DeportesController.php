<?php 
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class DeportesController extends Controller
{

	/**
	* @Route("/deportes")
	* @Route("/")
	*/
	public function inicio(){
		return new Response('Web principal deportes');
	}

	/**
	* @Route("/deportes/usuario", name="usuario" )
	*/
	public function sesionUsuario(Request $request) {
	      $usuario_get=$request->query->get('nombre');
	       $session = $request->getSession();
	       $session->set('nombre', $usuario_get);
	       return $this->redirectToRoute('usuario_session',array('nombre'=>$usuario_get));
	}
	/**
	* @Route("/deportes/usuario/{nombre}", name="usuario_session" )
	*/
	public function paginaUsuario() {
	   $session=new Session();
	   $usuario=$session->get('nombre');
	   return new Response(sprintf('Sesión iniciada con el atributo nombre: %s', $usuario
	   ));
	}

	/**
	* @Route("/deportes/{seccion}/{pagina}", name="lista_paginas",
	*    requirements={"pagina"="\d+"})
	*    defaults={"seccion":"tenis"}
	*/
	public function lista($seccion, $pagina=1){

		$deportes=["futbol", "tenis","rugby"];

		if(!in_array($seccion, $deportes)){
			throw $this->createNotFoundException('Error 404 esta seccion no existe.');
			
		}

		return new Response('Estas en la sección '.$seccion.' - página '.$pagina.'.');
	}

	/**
	* @Route("/deportes/{seccion}/{slug} ",
	* defaults={"seccion":"tenis"})
	*/
	public function noticia($slug, $seccion) {

	   return new Response(sprintf(
	       'Sección %s - noticia %s',
	       $seccion, $slug));
	}



	/**
	* @Route(
	*     "/deportes/{_idioma}/{fecha}/{seccion}/{equipo}/{pagina}",
	*     defaults={"slug": "1","_formato":"html","pagina":"1"},
	*     requirements={
	*         "_idioma": "es|en",
	*         "_formato": "html|json|xml",
	*         "fecha": "[\d+]{8}",
	*         "pagina"="\d+"
	*     }
	* )
	*/
	public function rutaAvanzadaListado($_idioma,$fecha, $seccion, $equipo, $pagina) {
	   return new Response(sprintf(
	       'Listado de noticias  en idioma=%s,
	        fecha=%s,deporte=%s,equipo=%s, página=%s ',
	       $_idioma, $fecha, $seccion, $equipo, $pagina));
	}
	
	/**
	* @Route(
	*    "/deportes/{_idioma}/{fecha}/{seccion}/{equipo}/{slug}.{_formato}",
	*     defaults={"slug": "1","_formato":"html"},
	*     requirements={
	*         "_idioma": "es|en",
	*         "_formato": "html|json|xml",
	*          "fecha": "[\d+]{8}"
	*     }
	* )
	*/
	public function rutaAvanzada($_idioma,$fecha, $seccion, $equipo, $slug) {

		$deportes=["valencia", "barcelona","federer", "rafa-nadal"];
		if(!in_array($equipo,$deportes)) {
		      return $this->redirectToRoute('inicio');
		   }

	   return new Response(sprintf(
	       'Idioma=%s,
	        fecha=%s,deporte=%s,equipo=%s, noticia=%s ',
	       $_idioma, $fecha, $seccion, $equipo, $slug));
	}




	
}