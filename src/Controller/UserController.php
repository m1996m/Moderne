<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FileUploadType;
use App\Form\UsereditType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
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
        $user=$repos->userSpecialite('65');
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
            'form'=>$form->createView()
        ]);
    }

     /**
     * @Route("/user/edit/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,User $user): Response
    {
        $form=$this->createForm(UsereditType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om=$this->getDoctrine()->getManager();
            $om->flush();
            return $this->redirectToRoute('user');
        }
        return $this->render('user/edit.html.twig', [
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
     /**
   * @Route("/upload/upload/{id}", name="app_test_upload")
   */
  public function upload(Request $request, FileUploader $file_uploader, User $user)
  {
    $form = $this->createForm(FileUploadType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) 
    {
      $file = $form['image']->getData();
      if ($file) 
      {
        $file_name = $file_uploader->upload($file);
        if (null !== $file_name) // for example
        {
          $directory = $file_uploader->getTargetDirectory();
          $full_path = $directory.'/'.$file_name;
          $user->setImage('image/'.$file_name);
          // Do what you want with the full path file...
          // Why not read the content or parse it !!!
         $om=$this->getDoctrine()->getManager();
          $om->flush();
        }
        else
        {
          // Oups, an error occured !!!
        }
      }
    }
    return $this->render('upload/upload.html.twig', [
      'form' => $form->createView(),
    ]);
  }

}
