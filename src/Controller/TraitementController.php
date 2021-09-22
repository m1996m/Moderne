<?php

namespace App\Controller;
use App\Entity\Traitement;
use App\Form\TraitementType;
use App\Repository\TraitementRepository;
use SessionIdInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TraitementController extends AbstractController
{
    /**
     * @Route("/traitement", name="traitement")
     */
    public function index(TraitementRepository $repos): Response
    {
        $traitements=$repos->findAll();
        return $this->render('traitement/mesPatient.html.twig', [
            'controller_name' => 'TraitementController',
            'traitements'=>$traitements
        ]);
    }

    /**
     * @Route("/priserendez/medecin/{id}", name="priserendez")
     */
    public function priserendez(TraitementRepository $repos): Response
    {
        $traitements=$repos->mesPatient($this->getUser());
        return $this->render('traitement/priserendez.html.twig', [
            'controller_name' => 'TraitementController',
            'traitements'=>$traitements
        ]);
    }
    /**
     * @Route("/mesPatient/{id}", name="mesPatient")
     */
    public function mespatient(TraitementRepository $repos): Response
    {
        $traitements=$repos->mesPatient($this->getUser());
        return $this->render('traitement/index.html.twig', [
            'controller_name' => 'TraitementController',
            'traitements'=>$traitements
        ]);
    }
    /**
     * @Route("/traitement/create", name="new_traitement", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request, SessionInterface $session,TraitementRepository $repos)
    {
       $traitement= new Traitement();
       $form=$this->createForm(TraitementType::class,$traitement);
       $form->handleRequest($request);
       $session->start();
       if($form->isSubmitted() &&  $form->isValid()){
            $traitement->setMedecin($this->getUser());
            $om=$this->getDoctrine()->getManager();
            $lasttraitement = $repos->findOneBy([], ['id' => 'desc']);
            //$lastId = $lasttraitement->getId();
            $session->set('traitement',$traitement);
            $om->persist($traitement);
            $om->flush();
            return $this->redirectToRoute('ordonnance_new');
       }
       return $this->render('traitement/create.html.twig',[
           'traitement' =>$traitement,
           'form'=>$form->createView()
       ]);

    }
    /**
     * @Route("/traitement/{id}/edit", name="edit_traitement", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Traitement $traitement):Response
    {
        $form=$this->createForm(TraitementType::class,$traitement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $om=$this->getDoctrine()->getManager();
            $om->flush();
            return $this->redirectToRoute('traitement');
        }
        return $this->render('traitement/edit.html.twig',[
            'traitement' =>$traitement,
            'form'=>$form->createView()
        ]);

    }

    /**
     * @Route("/{id}/traitement/show", name="show_traitement", methods={"GET"})
     */
    public function show(Traitement $traitement):Response
    {
        return $this->render('traitement/show.html.twig',[
            'traitement'=>$traitement
        ]);
    }

    /**
     * @Route("/{id}/traitement/facure", name="facture", methods={"GET"})
     */
    public function facture(Traitement $traitement):Response
    {
        return $this->render('traitement/facture.html.twig',[
            'facture'=>$traitement
        ]);
    }

    /**
     * @Route("/traitement/{id}/ordonnance", name="ordonnance", methods={"GET"})
     */
    public function ordonnance(Traitement $traitement):Response
    {
        return $this->render('traitement/ordonnance.html.twig',[
            'ordo'=>$traitement
        ]);
    }
    /**
     * @Route("/traitement/{id}/delete", name="delete_traitement", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Traitement $traitement, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete'.$traitement->getId(), $request->request->get('_token'))){
            $om=$this->getDoctrine()->getManager();
            $om->remove($traitement);
            $om->flush();
        }
        return $this->redirectToRoute('traitement');

    }
}
