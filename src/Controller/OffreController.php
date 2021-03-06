<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Pays;
use App\Entity\AgenceVoyage;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/offre")
 */
class OffreController extends AbstractController
{
    /**
     * @Route("/", name="offre_index", methods={"GET"})
     */
    public function index(OffreRepository $offreRepository): Response
    {
        return $this->render('offre/index.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }

    
         /**
     * @Route("/commandes", name="offre_commandes")
     */
    public function commandes (): Response
    {
        return $this->render('offre/commandes.html.twig');
    }

    /**
     * @Route("/new", name="offre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        
      

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $offre->setAgencevoyage($user->getAgenceVoyage()); 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('offre_index');
        }
       

        return $this->render('offre/form.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offre_show", methods={"GET"})
     */
    public function show(Offre $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="offre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offre $offre): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offre_index');
        }

        return $this->render('offre/form.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="offre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Offre $offre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offre_index');
    }
         /**
     * @Route("/pays/{id}", name="pays_del", methods={"DELETE"})
     */
    public function del(Request $request, Pays $pay): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($this->isCsrfTokenValid('delete'.$pay->getId(), $request->request->get('_token'))) {
            foreach($pay->getOffres() as $p){ 
                $p->removePay($pay);
                $pay->removeOffre($p);
                $entityManager->flush();

            }
        }



        return $this->redirectToRoute('offre_index');
    }

}
