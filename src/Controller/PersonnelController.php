<?php

namespace App\Controller;

use App\Entity\Personnel;
use App\Form\PersonnelType;
use App\Repository\PersonnelRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonnelController extends AbstractController
{



    /**
     * @Route("/personnel/create", name="personnel_new", methods={"GET","POST"})
    */
    public function create(Request $request): Response
    {
        $personnel = new Personnel();
        $form=$this->createForm(PersonnelType::class, $personnel);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $personnel->setUser($this->getUser());
            $om=$this->getDoctrine()->getManager();
            $om->persist($personnel);
            $om->flush();
            return $this->redirectToRoute("personnel");
        }
        return $this->render('personnel/create.html.twig', [
            'controller_name' => 'PersonnelController',
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/personnel/edit/{id}", name="personnel_edit", methods={"GET","POST"})
    */
    public function edit(Request $request, Personnel $perso): Response
    {
        $form=$this->createForm(PersonnelType::class, $perso);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $om=$this->getDoctrine()->getManager();
            $om->flush();
            return $this->redirectToRoute("personnel");
        }
        return $this->render('personnel/edit.html.twig', [
            'controller_name' => 'PersonnelController',
            'form'=>$form->createView()
        ]);
    }

        /**
     * @Route("/personnel/{id}/show", name="personnel_show", methods={"GET"})
     */
    public function show(Personnel $personnel): Response
    {
        return $this->render('personnel/show.html.twig', [
            'personnel' => $personnel
        ]);
    }

/**
     * @Route("/personnelss/delete/{id}", name="personnel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Personnel $personnel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personnel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personnel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('personnel');
    }
 


}
