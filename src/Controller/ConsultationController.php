<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\Consultation1Type;
use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/consultation")
 */
class ConsultationController extends AbstractController
{
    /**
     * @Route("/", name="consultation_index", methods={"GET"})
     */
    public function index(ConsultationRepository $consultationRepository): Response
    {
        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="consultation_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {
        
        $consultation = new Consultation();
        $form = $this->createForm(Consultation1Type::class, $consultation);
        $form->handleRequest($request);
        $session->start();

        if ($form->isSubmitted() && $form->isValid()) {
            $consultation->setMedecin($this->getUser());

            $session->set('patient',$consultation);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('allergie_new');
        }

        return $this->render('consultation/new.html.twig', [
            'consultation' => $consultation,
            'session'=>$session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consultation_show", methods={"GET"})
     */
    public function show(Consultation $consultation): Response
    {
        $users=$this->getUser();
        return $this->render('consultation/show.html.twig', [
            'user'=>$users,
            'consultation' => $consultation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consultation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Consultation $consultation): Response
    {
        $form = $this->createForm(Consultation1Type::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consultation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Consultation $consultation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($consultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('consultation_index');
    }
}
