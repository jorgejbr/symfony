<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\AuthenticationUtils;
use App\Entity\Noticia;
use App\Entity\Usuario;




class NoticiaController extends Controller
{

    /**
    * @Route("/deportes", name="inicio" )
    */
    public function inicio() {
      return $this->render("base.html.twig");
    }

    /**
    * @Route("/deportes/cargarbd", name="noticia")
    */
    public function cargarBd() {
       $em=$this->getDoctrine()->getManager();

       $noticia=new Noticia();
       $noticia->setSeccion("tenis");
       $noticia->setEquipo("roger-federer");
       $noticia->setFecha("16022018");

       //nuevos campos
        $noticia->setTextoTitular("Roger-Federer-a-una-victoria-del-número-uno-de-Nadal");
        $noticia->setTextoNoticia("El suizo Roger Federer, el tenista más laureado de la ");
        $noticia->setImagen('federer.jpg');

       $em->persist($noticia);
       $em->flush();
       return new Response("Noticia guardada con éxito con id:".$noticia->getId());
    }

    /**
    * @Route("/deportes/actualizar", name="actualizarNoticia")
    */
    public function actualizarBd(Request $request) {
       $em=$this->getDoctrine()->getManager();
       $id=$request->query->get('id');
       $noticia = $em->getRepository(Noticia::class)->find($id);

       $noticia->setTextoTitular("Roger-Federer-a-una-victoria-del-número-uno-de-Nadal");
       $noticia->setTextoNoticia("El suizo Roger Federer, ...");
       $noticia->setImagen('federer.jpg');
       $em->flush();

       return new Response("Noticia actualizada!");
    }


    /**
    * @Route("/deportes/eliminar", name="eliminarNoticia")
    */
    public function eliminarBd(Request $request) {
       $em=$this->getDoctrine()->getManager();
       $id=$request->query->get('id');
       $noticia = $em->getRepository(Noticia::class)->find($id);
       $em->remove($noticia);
       $em->flush();
       return new Response("Noticia eliminada!");
    }

    /**
    * @Route("/deportes/{seccion}/{pagina}", name="lista_paginas",
    *      requirements={"pagina"="\d+"},
    *      defaults={"seccion":"tenis"})
    */
    public function lista($pagina = 1, $seccion) {
       $em=$this->getDoctrine()->getManager();
       $repository = $this->getDoctrine()->getRepository(Noticia::class);
       //Buscamos las noticias de una sección
       $noticiaSec= $repository->findOneBy(['seccion' => $seccion]);
       // Si la sección no existe saltará una excepción
       if(!$noticiaSec) {
           throw $this->createNotFoundException('Este deporte no está en nuestra Base de Datos');
       }
       // Almacenamos todas las noticias de una sección en una lista
       $noticias = $repository->findBy([
           "seccion"=>$seccion
       ]);
       return $this->render('noticias/listar.html.twig', [
           // La función str_replace elimina los símbolos - de los títulos
           'titulo' => ucwords(str_replace('-', ' ', $seccion)),
           'noticias'=>$noticias
       ]);

    }


/**
 * @Route("/deportes/{seccion}/{titular} ",
 * defaults={"seccion":"tenis"}, name="verNoticia")
 */
 public function noticia($titular, $seccion)
  {
    $em=$this->getDoctrine()->getManager();
    $repository = $this->getDoctrine()->getRepository(Noticia::class);
    $noticia= $repository->findOneBy(['textoTitular' => $titular]);
    // Si la noticia que buscamos no se encuentra lanzamos error 404
    
   if(!$noticia){
            throw $this->createNotFoundException('Error 404 este deporte no está en nuestra Base de Datos');
      return $this->render("base.html.twig",[
                'texto'=>"Sorry Página no encontrada"
      ]);
    }
      return $this->render('noticias/noticia.html.twig', [
            // Parseamos el titular para quitar los símbolos -
            'titulo' => ucwords(str_replace('-', ' ', $titular)),
            'noticias'=>$noticia

        ]);
  }




}
