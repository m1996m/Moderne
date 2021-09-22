<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @Route("/rendez/vous")
 */
class RendezVousController extends AbstractController
{
    /**
     * @Route("/", name="rendez_vous_index", methods={"GET"})
     */
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findAll(),
        ]);
    }

    /**
     * @Route("/rendez/vous/rdv/{id}", name="rendezvous_rdv", methods={"GET"})
     */
    public function mesrdvparticulier(RendezVousRepository $rendezVousRepository): Response
    {
        //dd($rendezVousRepository->mesrdv($this->getUser()));
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVousRepository->mesrdv($this->getUser()),
        ]);
    }

    /**
     * @Route("/patient/medecin", name="patientmedecin", methods={"GET"})
     */
    public function patientMedecin(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findAll(),
        ]);
    }

    /**
     * @Route("/mesrendez/{id}", name="mesrendez", methods={"GET","POST"})
     */
    public function mesrendez(RendezVousRepository $rendezVousRepository, Request $request, RendezVous $rd): Response
    {
        $rdv=$rendezVousRepository->RENDEZVOUS($this->getUser());
        $form=$this->createForm(RendezVousType::class,$rd);
        $form->handleRequest($request);
        $baseurl = $request->getScheme();
        //dd($this->getUrl());
        //$lengh=$rdv.Length();
        if(isset($_POST['modifier'])){
            $rv=$rendezVousRepository->find($request->request->get('id'));
            $rd=$rv;
            $rd->setPatient($this->getUser());
            $rd->setDisponibilite(0);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('rendez_vous/new.html.twig', [
            'rdv' => $rdv,
        ]);
    }

    /**
     * @Route("/new", name="rendez_vous_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);
        //dd($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rendezVou);
            $entityManager->flush();

            return $this->redirectToRoute('rendez_vous_index');
        }

        return $this->render('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
    public function create(Request $request, RendezVousRepository $repos): Response
    {
        $heures=['8h00','9h00','10h00','11h00','12h00','13h00','14h00','15h00','16h00',
        '8h30','9h30','10h30','11h30', '12h30','13h30','14h30','15h30','16h30'];
        $rendezVou = new RendezVous();
        $erros=[];
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);
        $rd=$repos->rechercheRendezvous($this->getUser(),$rendezVou->getDate());
        $date= new DateTime();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if(!$rd){
                if($rendezVou->getDate()<$date->format('Y-m-d')){
                    $rendezVou1 = new RendezVous();
                    $rendezVou1 = $rendezVou1;
                     foreach($heures as $heure){
                        $rdv = new RendezVous();
                        $rdv->setMedecin($this->getUser());
                        $rdv->setStatut('non valide');
                        $rdv->setDisponibilite(1);
                        $rdv->setDate($rendezVou->getDate());
                        // $rendezVou->setService("'medicale'");
                        $rdv->setHeure($heure);
                        //dd($request);
                        //$entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($rdv);
                    }
                }else{
                    $erros[]="Cette date est deja passee";
                }
            }else{
                $erros[]="Vous avez dejà de rendez pour cette date la";
               // return $this->redirect($request->headers->get('referer'));
            }
            $entityManager->flush();
        }
       // return $this->redirectToRoute('rendez_vous_index');

        return $this->render('rendez_vous/create.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
            'erros'=>$erros
        ]);
    }
       /**
     * @Route("/tryForm", name="tryForm", methods={"POST"})
     */
    function tryForm(Request $request) {
        dd($request->request->get('heure'));
    }
 
    /**
     * @Route("/{id}", name="rendez_vous_show", methods={"GET"})
     */
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rendez_vous_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RendezVous $rendezVou): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rendez_vous_index');
        }

        return $this->render('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendez_vous_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RendezVous $rendezVou): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rendez_vous_index');
    }
}
