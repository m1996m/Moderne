<?php

namespace App\Controller;

use App\Entity\TypeExamen;
use App\Form\TypeExamenType;
use App\Repository\TypeExamenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/type/examen")
 *  @IsGranted("ROLE_ADMIN")
 */
class TypeExamenController extends AbstractController
{
    /**
     * @Route("/", name="type_examen_index", methods={"GET"})
     */
    public function index(TypeExamenRepository $typeExamenRepository): Response
    {
        return $this->render('type_examen/index.html.twig', [
            'type_examens' => $typeExamenRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_examen_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeExaman = new TypeExamen();
        $form = $this->createForm(TypeExamenType::class, $typeExaman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeExaman);
            $entityManager->flush();

            return $this->redirectToRoute('type_examen_index');
        }

        return $this->render('type_examen/new.html.twig', [
            'type_examan' => $typeExaman,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_examen_show", methods={"GET"})
     */
    public function show(TypeExamen $typeExaman): Response
    {
        return $this->render('type_examen/show.html.twig', [
            'type_examan' => $typeExaman,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_examen_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeExamen $typeExaman): Response
    {
        $form = $this->createForm(TypeExamenType::class, $typeExaman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_examen_index');
        }

        return $this->render('type_examen/edit.html.twig', [
            'type_examan' => $typeExaman,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_examen_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeExamen $typeExaman): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeExaman->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeExaman);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_examen_index');
    }
}
