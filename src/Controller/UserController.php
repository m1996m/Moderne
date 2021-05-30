<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user", methods={"GET"})
     */
    public function index(UserRepository $repos): Response
    {
        $user=$repos->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users'=>$user
        ]);
    }
    /**
     * @Route("/user/create", name="user_new", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $user=new User();
        $form= $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om=$this->getDoctrine()->getManager();
            $om->persist($user);
            $om->flush();
            return $this->redirectToRoute("user");
        }
    
        
        return $this->render('user/create.html.twig', [
            'user' => $user,
            'formulaire'=>$form->createView()
        ]);
    }

     /**
     * @Route("/user/edit/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,User $user): Response
    {

        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om=$this->getDoctrine()->getManager();
            $om->flush();
            return $this->redirectToRoute('user');
        }
        return $this->render('user/create.html.twig', [
            'user' => $user,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/create.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/user/delete/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(User $user, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))){
            $om=$this->getDoctrine()->getManager();
            $om->remove($user);
            $om->flush();
        }
        return $this->redirectToRoute('user');

    }

}
