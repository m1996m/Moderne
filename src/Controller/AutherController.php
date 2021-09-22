<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AutherController extends AbstractController
{
    /**
     * @Route("/langue/{locale}", name="langue")
     */
    public function langue($locale,Request $request): Response
    {
        //Recuperation de la session d'encours
        $request->getSession()->set('_locale',$locale);
        //dd($locale);
        //Redirection sur la route active
        return $this->redirect($request->headers->get('referer'));
    }
}
