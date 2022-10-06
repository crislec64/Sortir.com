<?php

namespace App\Controller;


use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\EditProfileType;
use App\Form\EditSortieType;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
        //alimenter l'organisateur
        $sortie = new Sortie();
        $sortie -> setOrganisateur($this ->getUser());

        $sortie -> setCampus($this ->getUser()->getCampus());

        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);

// renseigner le campus
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $etat = $entityManager ->getRepository(Etat::class)->findOneBy(['libelle'=>'Créée']);

            $sortie -> setEtat($etat);

            $entityManager->persist($sortie);
            $entityManager->flush();

        $this->addFlash('success', "Sortie créée !");
        return $this->redirectToRoute('main_home');
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
        if(!$sortie){
            throw $this->createNotFoundException(' existe pas!!');
        }
        return $this->render('main/home.html.twig',[
            "sortie"=> $sortie
        ]);
    }


    /**
     *
     * @Route("/profile/editSortie", name="editSortie")
     */
    public function editSortie(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $sortieForm = $this->createForm(EditSortieType::class, $user);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('message', 'la sortie à bien été modifiée');
            return $this->redirectToRoute('index');
        }

        return $this->render('main/home.html.twig', [
            'sortieForm' => $sortieForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="deleteSortie")
     */
    public function delete (Sortie $sortie, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($sortie);
        $entityManager->flush();


        return $this->redirectToRoute('main_home');
    }

}


