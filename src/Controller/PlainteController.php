<?php

namespace App\Controller;

use App\Entity\Plainte;
use App\Form\PlainteType;
use App\Repository\ConsultationRepository;
use App\Repository\PlainteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/plainte")
 */
class PlainteController extends AbstractController
{
    /**
     * @Route("/", name="plainte_index", methods={"GET"})
     */
    public function index(PlainteRepository $plainteRepository): Response
    {
        return $this->render('plainte/index.html.twig', [
            'plaintes' => $plainteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="plainte_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session, ConsultationRepository $repos): Response
    {
        $plainte = new Plainte();
        $form = $this->createForm(PlainteType::class, $plainte);
        $form->handleRequest($request);
        $patient=$repos->find($session->get('patient','id'));
        $plainte->setConsultation($patient) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plainte);
            $entityManager->flush();
            return $this->redirectToRoute('plainte_new');
        }

        return $this->render('plainte/new.html.twig', [
            'plainte' => $plainte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plainte_show", methods={"GET"})
     */
    public function show(Plainte $plainte): Response
    {
        return $this->render('plainte/show.html.twig', [
            'plainte' => $plainte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="plainte_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Plainte $plainte): Response
    {
        $form = $this->createForm(PlainteType::class, $plainte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plainte_index');
        }

        return $this->render('plainte/edit.html.twig', [
            'plainte' => $plainte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plainte_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Plainte $plainte): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plainte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plainte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plainte_index');
    }
}
