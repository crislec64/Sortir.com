<?php

namespace App\Controller;


use App\Entity\Sortie;
use App\Form\SortieType;
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

        if ($sortieForm->isSubmitted()){
            $entityManager->persist($sortie);
            $entityManager->flush();
        }

        //TODO traiter le formulaire

        return $this->render('main/sortie_creation.html.twig', [
            'sortieForm' => $sortieForm ->createView()
        ]);
    }



    /**
     * @Route("/", name="sortie_liste")
     */
    public function listSorties(): Response
    {
        //TODO aller chercher toutes les sorties

        return $this->render('main/home.html.twig');
    }



    /**
     * @Route("/details/{id}", name="sortie_details")
     */
    public function afficherUneSortie(int $id): Response
    {
        //TODO aller chercher la sortie dans la bdd

        return $this->render('main/sortie_details.html.twig');
    }

}


