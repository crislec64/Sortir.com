<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route ("/admin", name="admin_")
 */
class VilleController extends AbstractController
{
    /**
     * @Route ("/list", name="list")
     */

    public function List(VilleRepository $villeRepository):Response
    {

        $villes = $villeRepository->findAll();
        return $this ->render('admin/list.html.twig' ,[
            "villes" => $villes
        ]);
    }

    /**
     * @Route("/villeTest", name="em-villetest")
     */
    public function villeTest (EntityManagerInterface $entityManager): Response
   {
       $ville = new Ville();

       $ville->setNom('Biarritz');
       $ville->setCodePostal('64200');

       $entityManager->persist($ville);
       $entityManager->flush();

       dump($ville);

       return $this ->render('admin/list.html.twig');
   }

    /**
     * @Route("/create", name="create")
     */
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ):Response
    {

        $ville = new Ville();
        $villeForm = $this->createForm(VilleType::class, $ville);
        $villeForm->handleRequest($request);


        if($villeForm-> isSubmitted() && $villeForm-> isValid()){
            $entityManager->persist($ville);
            $entityManager->flush();


            $this->addFlash('success', 'Une ville a été ajoutée');


            return $this->redirectToRoute('main_home');
        }

        return $this->render('admin/create.html.twig',[
            'villeForm' => $villeForm->createView()
        ]);


    }
}