<?php

namespace App\Controller;

use App\Entity\Allergie;
use App\Form\AllergieType;
use App\Repository\AllergieRepository;
use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/allergie")
 */
class AllergieController extends AbstractController
{
    /**
     * @Route("/", name="allergie_index", methods={"GET"})
     */
    public function index(AllergieRepository $allergieRepository): Response
    {
        return $this->render('allergie/index.html.twig', [
            'allergies' => $allergieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="allergie_new", methods={"GET","POST"})
     */
    public function new(Request $request, ConsultationRepository $repos,SessionInterface $session): Response
    {
        $allergie = new Allergie();
        $form = $this->createForm(AllergieType::class, $allergie);
        $form->handleRequest($request);
        //$user=$repos->findBy($this->get('session','id'));
        //dd($this->get('','id'));
        $patient=$repos->find($session->get('patient','id'));
        
       $allergie->setConsultation($patient) ;
      // dd($session->get('patient'));
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($allergie);
            $entityManager->flush();

            return $this->redirectToRoute('allergie_new');
    //$this->redirect($request->getReferer());
        }

        return $this->render('allergie/new.html.twig', [
            'allergie' => $allergie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="allergie_show", methods={"GET"})
     */
    public function show(Allergie $allergie): Response
    {
        return $this->render('allergie/show.html.twig', [
            'allergie' => $allergie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="allergie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Allergie $allergie): Response
    {
        $form = $this->createForm(AllergieType::class, $allergie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('allergie_index');
        }

        return $this->render('allergie/edit.html.twig', [
            'allergie' => $allergie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="allergie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Allergie $allergie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$allergie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($allergie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('allergie_index');
    }
}
