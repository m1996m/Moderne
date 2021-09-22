<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangepasswordType;
use App\Form\FileUploadType;
use App\Form\UsereditType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Gedmo\Mapping\Annotation\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;

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
     * @Route("/user/prise/", name="prendrerendez", methods={"GET"})
     */
    public function prise(UserRepository $repos): Response
    {
        $role[]='ROLE_ADMIN';
        $user=$repos->peronnels();
        return $this->render('user/priserendez.html.twig', [
            'controller_name' => 'UserController',
            'traitements'=>$user
        ]);
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(UserRepository $repos): Response
    {
        $user=$repos->userSpecialite('65');
        return $this->render('user/home.html.twig', [
            'users'=>$user
        ]);
    }
        /**
     * @Route("/us/{id}/", name="mespa", methods={"GET"})
     */
    public function mesPatients(UserRepository $userRepository,User $user): Response
    {
        return $this->render('user/mesPatient.html.twig', [
            'users' => $userRepository->mesPatients($this->getUser()),
        ]);
    }
    /**
     * @Route("/create/user", name="user_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
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
            return $this->redirectToRoute("app_login");
        }
    
        
        return $this->render('user/create.html.twig', [
            'user' => $user,
            'form'=>$form->createView()
        ]);
    }

     /**
     * @Route("/user/edit/{slug}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,User $user): Response
    {
        $form=$this->createForm(UsereditType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om=$this->getDoctrine()->getManager();
            $om->flush();
            return $this->redirectToRoute('user_show',['slug' => $this->getUser()->getSlug()]);
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form'=>$form->createView()
        ]);
    }
     /**
     * @Route("/user/{slug}/changepassword", name="nouveau", methods={"GET","POST"})
     */
    public function changepassword(Request $request,User $user,UserPasswordEncoderInterface $encoder): Response
    {
        $form=$this->createForm(ChangepasswordType::class,$user);
        $form->handleRequest($request);
        //dd($user);
        //$user = $$this->getDoctrine()->getManager()->getRepository(User::class)->findBy(['email' => $this->getUser()->getEmail()]);
         if($form->isSubmitted() && $form->isValid()){
            $change=$user->getNouveau();
            $confirmation=$user->getConfirmation();
            $ancien=$encoder->encodePassword($user, $user->getAncien());
            $anciens=$encoder->encodePassword($this->getUser(), $this->getUser()->getPassword() );
           // dd($encoder->encodePassword($user, '12345678'));
            if($ancien!=$anciens ){
               // dd($user);
             if($change==$confirmation){
                    $user->setPassword($encoder->encodePassword($user,$user->getNouveau()));
                    $om=$this->getDoctrine()->getManager();
                    $om->flush();
                    return $this->redirectToRoute('user_show',['slug' => $this->getUser()->getSlug()]);
                }else{
                    $this->addFlash('Erreur','Nouveau mot de passe different de la confirmation');
                }

            }else{
                $this->addFlash('Erreur','ancien mot de passe different du nouveau');
            }
        }
        return $this->render('user/changePassword.html.twig', [
            'user' => $user,
            'registrationForm'=>$form->createView()
        ]);
    }
    /**
     * @Route("/user/{slug}", name="user_show", methods={"GET"})
     *
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/user/delete/{slug}", name="user_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
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
   * @Route("/upload/upload/{slug}", name="app_test_upload")
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
          return $this->redirectToRoute('user_show', ['slug' => $this->getUser()->getSlug()]);
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
