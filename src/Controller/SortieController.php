<?php

namespace App\Controller;


use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{

/**
 * @Route("/creation",name="creation")
 */
    public function createSortie(
        Request $request,
        EntityManagerInterface $entityManager
        ):Response
    {
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $entityManager->persist($sortie);
            $entityManager->flush();


        $this->addFlash('success', "Sortie créée !");
        return $this->redirectToRoute('sortie_details', ['id' => $sortie->getId()]);
        //TODO traiter le formulaire
    }

        return $this->render('main/sortie_creation.html.twig', [
            'sortieForm' => $sortieForm ->createView()
        ]);
    }



    /**
     * @Route("/", name="sortie_liste")
     */
    public function listSorties(int $id, SortieRepository $sortieRepository): Response
    {
       $sortie = $sortieRepository-> find($id);

       if(!$sortie){
           throw $this ->createNotFoundException('Il y a pas ce que vous cherchez ici...');
       }

        return $this->render('main/home.html.twig',[
            "sortie" => $sortie
        ]);
    }



    /**
     * @Route("/details/{id}", name="sortie_details")
     */
    public function afficherUneSortie(int $id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository ->find($id);

        return $this->render('main/sortie_details.html.twig',[
            "sortie" => $sortie
        ]);
    }

    /**
     * @Route("/delete/{id}", name="sortie_delete")
     */
    public function supprimerSortie(Sortie $sortie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($sortie);
        $entityManager->flush();

        $this->addFlash('success',"Sortie supprimée !");

        return $this->render('main/home.html.twig');
    }

}

