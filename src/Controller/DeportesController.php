<?php 
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DeportesController
{

	/**
	* @Route("/deportes")
	*/
	public function inicio(){
		return new Response('Web principal deportes');
	}

	/**
	 * @Route("/deportes/web1")
	 */

	public function mostrar(){
		return new Response('Web numero 1');
	}
}