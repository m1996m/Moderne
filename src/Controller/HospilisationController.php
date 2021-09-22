<?php

namespace App\Controller;

use App\Entity\Hospilisation;
use App\Form\HospilisationType;
use App\Repository\HospilisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/hospilisation")
 */
class HospilisationController extends AbstractController
{
    /**
     * @Route("/", name="hospilisation_index", methods={"GET"})
     */
    public function index(HospilisationRepository $hospilisationRepository): Response
    {
        return $this->render('hospilisation/index.html.twig', [
            'hospilisations' => $hospilisationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hospilisation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hospilisation = new Hospilisation();
        $form = $this->createForm(HospilisationType::class, $hospilisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hospilisation);
            $entityManager->flush();

            return $this->redirectToRoute('hospilisation_index');
        }

        return $this->render('hospilisation/new.html.twig', [
            'hospilisation' => $hospilisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hospilisation_show", methods={"GET"})
     */
    public function show(Hospilisation $hospilisation): Response
    {
        return $this->render('hospilisation/show.html.twig', [
            'hospilisation' => $hospilisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hospilisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hospilisation $hospilisation): Response
    {
        $form = $this->createForm(HospilisationType::class, $hospilisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hospilisation_index');
        }

        return $this->render('hospilisation/edit.html.twig', [
            'hospilisation' => $hospilisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hospilisation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Hospilisation $hospilisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hospilisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hospilisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hospilisation_index');
    }
}
