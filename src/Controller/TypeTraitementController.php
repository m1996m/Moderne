<?php

namespace App\Controller;

use App\Entity\TypeTraitement;
use App\Form\TypeTraitementType;
use App\Repository\TypeTraitementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/traitement")
 */
class TypeTraitementController extends AbstractController
{
    /**
     * @Route("/", name="type_traitement_index", methods={"GET"})
     */
    public function index(TypeTraitementRepository $typeTraitementRepository): Response
    {
        return $this->render('type_traitement/index.html.twig', [
            'type_traitements' => $typeTraitementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_traitement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeTraitement = new TypeTraitement();
        $form = $this->createForm(TypeTraitementType::class, $typeTraitement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeTraitement);
            $entityManager->flush();

            return $this->redirectToRoute('type_traitement_index');
        }

        return $this->render('type_traitement/new.html.twig', [
            'type_traitement' => $typeTraitement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_traitement_show", methods={"GET"})
     */
    public function show(TypeTraitement $typeTraitement): Response
    {
        return $this->render('type_traitement/show.html.twig', [
            'type_traitement' => $typeTraitement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_traitement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeTraitement $typeTraitement): Response
    {
        $form = $this->createForm(TypeTraitementType::class, $typeTraitement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_traitement_index');
        }

        return $this->render('type_traitement/edit.html.twig', [
            'type_traitement' => $typeTraitement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_traitement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeTraitement $typeTraitement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeTraitement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeTraitement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_traitement_index');
    }
}
