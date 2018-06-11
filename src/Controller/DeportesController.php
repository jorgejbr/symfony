<?php 
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DeportesController
{

	/**
	* @Route("/deportes")
	* @Route("/")
	*/
	public function inicio(){
		return new Response('Web principal deportes');
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
	* @Route("/deportes/{seccion}/{pagina}", name="lista_paginas",
	*    requirements={"pagina"="\d+"})
	*    defaults={"seccion":"tenis"}
	*/
	public function lista($seccion, $pagina=1){
		return new Response('Estas en la sección '.$seccion.' - página '.$pagina.'.');
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
	   return new Response(sprintf(
	       'Idioma=%s,
	        fecha=%s,deporte=%s,equipo=%s, noticia=%s ',
	       $_idioma, $fecha, $seccion, $equipo, $slug));
	}


	
}