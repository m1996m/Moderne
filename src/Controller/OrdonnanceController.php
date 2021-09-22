<?php

namespace App\Controller;

use App\Entity\Ordonnance;
use App\Form\OrdonnanceType;
use App\Repository\ConsultationRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\TraitementRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/ordonnance")
 */
class OrdonnanceController extends AbstractController
{
    /**
     * @Route("/", name="ordonnance_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(OrdonnanceRepository $ordonnanceRepository): Response
    {
        return $this->render('ordonnance/index.html.twig', [
            'ordonnances' => $ordonnanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="mesOrdonnance", methods={"GET"})
     */
    public function mesordonnance(OrdonnanceRepository $ordonnanceRepository): Response
    {
        $user=$this->getUser();
        return $this->render('ordonnance/ordonnance.html.twig', [
            'ordonnances' => $ordonnanceRepository->mesordonnances($this->getUser()),
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/new", name="ordonnance_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, SessionInterface $session, ConsultationRepository $consul, TraitementRepository $tr): Response
    {
        $ordonnance = new Ordonnance();
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);
        $consultation=$consul->find($session->get('consultation','id'));
        $traitement=$tr->find($session->get('traitement','id'));
        $ordonnance->setConsultation($consultation);
        $ordonnance->setTraitement($traitement);
        $ordonnance->setCreatedAt(new DateTime());
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ordonnance);
            $entityManager->flush();
            return $this->redirectToRoute('ordonnance_new');
        }

        return $this->render('ordonnance/new.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ordonnance_show", methods={"GET"})
     */
    public function show(Ordonnance $ordonnance): Response
    {
        return $this->render('ordonnance/show.html.twig', [
            'ordonnance' => $ordonnance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ordonnance_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Ordonnance $ordonnance): Response
    {
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ordonnance_index');
        }

        return $this->render('ordonnance/edit.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ordonnance_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Ordonnance $ordonnance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordonnance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ordonnance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ordonnance_index');
    }
}
