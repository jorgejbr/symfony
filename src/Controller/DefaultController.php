<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;

class DefaultController extends Controller
{
    /**
     * @Route("/product", name="product")
     */
    public function createAction()
    {
        $product = new Product();
        $product->setName('prueba1');
        $em = $this->getDoctrine()->getManager();
        $product->setPrice('18.22');
        $em->persist($product);
        $em->flush();
        return new Response('Product with id '.$product->getId().' created.');
    }


    /**
     * @Route("/product/{id}", name="showProduct")
     */
    public function showAction($id){
        $product=$this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        if(!$product){
            throw $this->createNotFoundException(
                'No product found with id: '.$id
            );
        }else{
            return new Response(dump($product));
        }
    }


    /**
     * @Route("/product/{id}/update/price/{price}", name="chanfeProductPrice")
     */
    public function changePrice($id,$price){
        $em = $this->getDoctrine()->getManager();
        $product=$this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        $product->setPrice($price);
        
        return $this->redirectToRoute('showProduct', ['id'=> $id]);
    }

}

