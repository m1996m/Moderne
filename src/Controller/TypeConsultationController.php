<?php

namespace App\Controller;

use App\Entity\TypeConsultation;
use App\Form\TypeConsultationType;
use App\Repository\TypeConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/type/consultation")
 *  @IsGranted("ROLE_ADMIN")
 */
class TypeConsultationController extends AbstractController
{
    /**
     * @Route("/", name="type_consultation_index", methods={"GET"})
     */
    public function index(TypeConsultationRepository $typeConsultationRepository): Response
    {
        return $this->render('type_consultation/index.html.twig', [
            'type_consultations' => $typeConsultationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_consultation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeConsultation = new TypeConsultation();
        $form = $this->createForm(TypeConsultationType::class, $typeConsultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeConsultation);
            $entityManager->flush();

            return $this->redirectToRoute('type_consultation_index');
        }

        return $this->render('type_consultation/new.html.twig', [
            'type_consultation' => $typeConsultation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_consultation_show", methods={"GET"})
     */
    public function show(TypeConsultation $typeConsultation): Response
    {
        return $this->render('type_consultation/show.html.twig', [
            'type_consultation' => $typeConsultation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_consultation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeConsultation $typeConsultation): Response
    {
        $form = $this->createForm(TypeConsultationType::class, $typeConsultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_consultation_index');
        }

        return $this->render('type_consultation/edit.html.twig', [
            'type_consultation' => $typeConsultation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_consultation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeConsultation $typeConsultation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeConsultation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeConsultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_consultation_index');
    }
}
